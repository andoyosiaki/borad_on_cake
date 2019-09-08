<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Tweets Controller
 *
 * @property \App\Model\Table\TweetsTable $Tweets
 *
 * @method \App\Model\Entity\Tweet[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TweetsController extends AppController
{
    public $paginate = [
      'limit' => 50,
      'order' => ['Tweets.id' => 'desc'],
      'contain' => ['Users']
    ];

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {

        $tweets = $this->paginate($this->Tweets);

        $username = $this->Session->read('username');
        $user_id = $this->Session->read('user_id');
        $this->set(compact('user_id','username'));

        $this->set(compact('tweets'));

    }

    /**
     * View method
     *
     * @param string|null $id Tweet id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tweet = $this->Tweets->get($id, [
            'contain' => ['Users', 'Replys']
        ]);

        $this->set('tweet', $tweet);

        $username = $this->Session->read('username');
        $user_id = $this->Session->read('user_id');

        $this->set(compact('user_id','username'));


        $result = $this->Tweets->Replys->find()->contain(['Users'])->where(['tweet_id' => $id]);
        $this->set(compact('result'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $username = $this->Session->read('username');
        $user_id = $this->Session->read('user_id');

        $tweet = $this->Tweets->newEntity();


        if ($this->request->is('post')) {

            $tweet = $this->Tweets->patchEntity($tweet, $this->request->getData());
            $tweet->user_id = $user_id;
            $tweet->create_at = time();
            $post = $this->request->getData();

            $tweet->tweet_img = md5(uniqid(rand(),true));
            $img_error = $post['img_name']['error'];

            if(MAX_FILE_SIZE > $post['img_name']['size'] && $img_error === 0){

              $ext =  $this->_CutExt_Lower($post['img_name']['name']);
              if($img_error === 0 && $ext === '.jpg' || $ext === '.png'){

                $img_adress = $this->_CreateImagePath($username,$user_id,$ext);
                $tweet->image_pass = $img_adress;

                list($baseImage,$width,$hight) = $this->_images($post['img_name']['tmp_name'],PROTO_IMG,$img_adress);
                $image = imagecreatetruecolor(THUMB_WIDTH, THUMB_HEIGHT);
                $this->_CreatTtumb($image,$baseImage,COMPRE_IMG,$width,$hight,$img_adress);
              }else {
                $error = 'extension';
              }
            }

            if($img_error === 0 || $post['content']){
              if ($this->Tweets->save($tweet)) {
                 return $this->redirect(['action' => 'index']);
              }
            }else {
              $this->Flash->error(__('The tweet could not be saved. Please, try again.'));
              return $this->redirect(['action' => 'index']);
            }

        }
        $users = $this->Tweets->Users->find('list', ['limit' => 200]);
        $this->set(compact('tweet', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tweet id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function image($id = null)
    {
        $tweet = $this->Tweets->get($id, [
            'contain' => []
        ]);
         $this->set(compact('tweet'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tweet id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {

      $tweet = $this->Tweets->get($id, [
          'contain' => ['Users', 'Replys']
      ]);

        $this->request->allowMethod(['post', 'delete']);
        $tweet = $this->Tweets->get($id);

        if(isset($tweet['image_pass'])){
          $this->_DeleteFile_2(PROTO_IMG,COMPRE_IMG,$tweet['image_pass']);
        }

        if($tweet['maxpost'] > 0){
          $replytweet = $this->Tweets->find()->where(['id' => $id]);
          foreach ($replytweet as $key) {
            $UniqueId = $key['tweet_img'];
          }
          $R_CompreImage = WWW_ROOT.IMAGES_DIR.R_COMPRE_IMG.$UniqueId;
          $R_ProtoImage = WWW_ROOT.IMAGES_DIR.R_PROTO_IMG.$UniqueId;
          foreach (glob(WWW_ROOT.IMAGES_DIR.R_COMPRE_IMG.'*'.$UniqueId.'*') as $R_CompreImage) {
            unlink($R_CompreImage);
          }
          foreach (glob(WWW_ROOT.IMAGES_DIR.R_PROTO_IMG.'*'.$UniqueId.'*') as $R_ProtoImage) {
            unlink($R_ProtoImage);
          }
        }



        if ($this->Tweets->delete($tweet)) {
            $this->Flash->success(__('The tweet has been deleted.'));
        } else {
            $this->Flash->error(__('The tweet could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function beforeFilter(Event $event){
      parent::beforeFilter($event);
      $this->Auth->allow(['index']);
    }

    public function isAuthorized($user = null){
      $action = $this->request->parames['action'];

        if(in_array($action,['view'])){
        return true;
      }

      if($user['role'] === 'user'){
        return true;
      }
    }


    public function _CutExt_Lower($data){
       return strtolower(substr($data,-4));
    }

    public function _images($data,$dir,$pass){
    move_uploaded_file($data,WWW_ROOT.IMAGES_DIR.$dir.$pass);
    list($width, $hight,$info) = getimagesize(WWW_ROOT.IMAGES_DIR.$dir.$pass); // 元の画像名を指定してサイズを取得
    switch($info){
    case 2:
    $base = imagecreatefromjpeg(WWW_ROOT.IMAGES_DIR.$dir.$pass);
    break;
    case 3:
    $base = imagecreatefrompng(WWW_ROOT.IMAGES_DIR.$dir.$pass);
    break;
    }
    return array($base,$width,$hight);
  }

  public function _CreatTtumb($img,$base,$dir,$w,$h,$adress){
    if($dir ==='Compre_img/' || $dir === 'Reply_Compre_img/'){
      imagecopyresampled($img,$base, 0, 0, 0, 0,THUMB_WIDTH,THUMB_HEIGHT, $w, $h);
      return imagejpeg($img,WWW_ROOT.IMAGES_DIR.$dir.$adress);
    }elseif($dir === 'Profile_Compre_img/'){
      imagecopyresampled($img,$base, 0, 0, 0, 0,ICON_SIZE,ICON_SIZE, $w, $h);
      return imagejpeg($img,WWW_ROOT.IMAGES_DIR.$dir.$adress);
    }
  }

  public function _CreateImagePath($sessionname,$sessionid,$extension){
      $rec = $sessionid;
      $day = time();
      return  $img =  $sessionname.$day.$sessionid.$extension;
  }


  public function _DeleteFile_2($dir1,$dir2,$data){
    $file1 = WWW_ROOT.IMAGES_DIR.$dir1.$data;
    $file2 = WWW_ROOT.IMAGES_DIR.$dir2.$data;
    unlink($file1);
    unlink($file2);
  }
}
