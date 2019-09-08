<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Replys Controller
 *
 * @property \App\Model\Table\ReplysTable $Replys
 *
 * @method \App\Model\Entity\Reply[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReplysController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Tweets', 'Users']
        ];
        $replys = $this->paginate($this->Replys);

        $this->set(compact('replys'));
    }

    /**
     * View method
     *
     * @param string|null $id Reply id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $reply = $this->Replys->get($id, [
            'contain' => ['Tweets', 'Users']
        ]);

        $this->set('reply', $reply);

        $username = $this->Session->read('username');
        $user_id = $this->Session->read('user_id');

        $this->set(compact('user_id','username'));
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

        $reply = $this->Replys->newEntity();
        if ($this->request->is('post')) {
            $reply = $this->Replys->patchEntity($reply, $this->request->getData());
            $reply->user_id = $user_id;
            $reply->create_at = time();

            $post = $this->request->getData();
            $img_error = $post['reply_img']['error'];

            if(!empty($post['reply_img']['name']) && MAX_FILE_SIZE > $post['reply_img']['size'] && $img_error === 0){

              $ext =  $this->_CutExt_Lower($post['reply_img']['name']);
              if($img_error === 0 && $ext === '.jpg' || $ext === '.png'){

                $tweet_img = $this->Replys->Tweets->find()->where(['id' => $post['tweet_id']]);
                foreach ($tweet_img as $key) {
                  $uniq_id = $key['tweet_img'];
                }
                $img_adress = $this->_CreateImagePath_replys($uniq_id,$username,$user_id,$ext);

                $reply->reply_img = $img_adress;

                list($baseImage,$width,$hight) = $this->_images($post['reply_img']['tmp_name'],R_PROTO_IMG,$img_adress);
                $image = imagecreatetruecolor(THUMB_WIDTH, THUMB_HEIGHT);
                $this->_CreatTtumb($image,$baseImage,R_COMPRE_IMG,$width,$hight,$img_adress);
              }else {
                $reply->reply_img = 0;
              }
            }else {
              $reply->reply_img = 0;
            }

            $max = $this->Replys->find()->where(['tweet_id' =>$reply->tweet_id])->count();

            $tweetsTable = $this->getTableLocator()->get('Tweets');
            $newcount = $tweetsTable->get($reply->tweet_id);
            $newcount->maxpost = ($max + 1);
            $tweetsTable->save($newcount);

            if ($this->Replys->save($reply)) {

                return $this->redirect(['controller' => 'tweets','action' => 'view/'.$reply->tweet_id]);
            }
            $this->Flash->error(__('The reply could not be saved. Please, try again.'));
        }

        $tweets = $this->Replys->Tweets->find('list', ['limit' => 200]);
        $users = $this->Replys->Users->find('list', ['limit' => 200]);
        $this->set(compact('reply', 'tweets', 'users'));
    }

    public function image($id = null)
    {
        $tweet = $this->Replys->get($id, [
            'contain' => []
        ]);
         $this->set(compact('tweet'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Reply id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $reply = $this->Replys->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $reply = $this->Replys->patchEntity($reply, $this->request->getData());
            if ($this->Replys->save($reply)) {
                $this->Flash->success(__('The reply has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reply could not be saved. Please, try again.'));
        }
        $tweets = $this->Replys->Tweets->find('list', ['limit' => 200]);
        $users = $this->Replys->Users->find('list', ['limit' => 200]);
        $this->set(compact('reply', 'tweets', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Reply id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $reply = $this->Replys->get($id);

        $max = $this->Replys->find()->where(['tweet_id' =>$reply->tweet_id])->count();
        $tweetsTable = $this->getTableLocator()->get('Tweets');
        $newcount = $tweetsTable->get($reply->tweet_id);
        $newcount->maxpost = ($max - 1);
        $tweetsTable->save($newcount);


        if(isset($reply['reply_img'])){
          $this->_DeleteFile_2(R_PROTO_IMG,R_COMPRE_IMG,$reply['reply_img']);
        }

        if ($this->Replys->delete($reply)) {
            $this->Flash->success(__('The reply has been deleted.'));
        } else {
            $this->Flash->error(__('The reply could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'tweets','action' => 'view/'.$reply->tweet_id]);
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

  public function _CreateImagePath_replys($uniq,$sessionname,$sessionid,$extension){
    $uniq = $uniq;
    $day = time();
    return  $img =  $sessionname.$uniq.$day.$sessionid.$extension;
  }

  public function _DeleteFile_2($dir1,$dir2,$data){
    $file1 = WWW_ROOT.IMAGES_DIR.$dir1.$data;
    $file2 = WWW_ROOT.IMAGES_DIR.$dir2.$data;
    unlink($file1);
    unlink($file2);
  }
}
