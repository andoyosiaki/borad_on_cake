<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Http\Cookie\Cookie;
use Cake\Event\Event;
use Cake\I18n\Time;
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

    public $components = ['Image'];

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {

      $username = $this->Session->read('username');
      $user_id = $this->Session->read('user_id');
      $this->set(compact('user_id','username'));

      $tweets = $this->paginate($this->Tweets);
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

        $desc = $this->Tweets->find()->where(['id' => $id]);

        foreach ($desc as $key) {
          $restriction = $key['restriction'];
          $owner = $key['user_id'];
        }
        $this->set(compact('restriction','owner'));

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

            if($tweet->getErrors()){
               $this->Flash->error(__('２００文字以内でお願いします'));
               return $this->redirect(['action' => 'index']);exit();
            }

            $tweet->user_id = $user_id;
            $tweet->create_at = new Time(date('Y-m-d H:i:s'));

            $post = $this->request->getData();

            if(isset($post['img_name']['error']) && $post['img_name']['error'] === 0){
              $img_error = $post['img_name']['error'];
              $tweet->tweet_img = md5(uniqid(rand(),true));

              if(MAX_FILE_SIZE > $post['img_name']['size'] && $img_error === 0){
                $ext = $this->Image->CutExt_Lower($post['img_name']['name']);
                if($img_error === 0 && $ext === '.jpg' || $ext === '.png'){

                  $img_adress = $this->Image->CreateImagePath($username,$user_id,$ext);
                  $tweet->image_pass = $img_adress;

                  list($baseImage,$width,$hight) = $this->Image->images($post['img_name']['tmp_name'],PROTO_IMG,$img_adress);
                  $image = imagecreatetruecolor(THUMB_WIDTH, THUMB_HEIGHT);
                  $this->Image->CreatTtumb($image,$baseImage,COMPRE_IMG,$width,$hight,$img_adress);
                }
              }else {
                $tweet->image_pass = 0;
              }
            }else {
              $tweet->image_pass = 0;
            }

            $tweet->restriction = $post['restriction'];

            if(isset($img_error) && $img_error === 0 || $post['content']){
              if ($this->Tweets->save($tweet)) {
                 return $this->redirect(['action' => 'index']);
              }
            }else {
              $this->Flash->error(__('The tweet could not be saved. Please, try again.'));
              return $this->redirect(['action' => 'index']);
            }
        }else {
          return $this->redirect(['action' => 'index']);
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

        //投稿に添付された画像ファイルの削除
        if(!empty($tweet['image_pass'])){
          $this->Image->DeleteFile_2(PROTO_IMG,COMPRE_IMG,$tweet['image_pass']);
        }

        //投稿に対しての返信に付けられた画像ファイルの削除
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

        $this->loadModel('Replys');
        $replypost = $this->Replys->find()->where(['tweet_id' => $id]);
        foreach($replypost as $deletekey){
          $this->Replys->delete($deletekey);
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
      $this->Auth->allow(['index','view']);
    }

    public function isAuthorized($user = null){
      $action = $this->request->getParam(['action']);

        if(in_array($action,['view'])){
        return true;
      }

      if($user['role'] === 'user'){
        return true;
      }
    }
}
