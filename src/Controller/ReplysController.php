<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;

/**
 * Replys Controller
 *
 * @property \App\Model\Table\ReplysTable $Replys
 *
 * @method \App\Model\Entity\Reply[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReplysController extends AppController
{

    public $components = ['Image'];


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
            $reply->create_at = new Time(date('Y-m-d H:i:s'));

            $post = $this->request->getData();
            if($reply->reply_img === null){
              $reply->reply_img = 0;
            }
            if($reply->getErrors()){
               $this->Flash->error(__('２００文字以内でお願いします'));
               return $this->redirect(['controller' => 'tweets','action' => 'view/'.$reply->tweet_id]);exit();
            }

            if(isset($post['reply_img']['error']) && $post['reply_img']['error'] === 0){
              $img_error = $post['reply_img']['error'];
            }

            if(!empty($post['reply_img']['name']) && MAX_FILE_SIZE > $post['reply_img']['size'] && $img_error === 0){

              $ext = $this->Image->CutExt_Lower($post['reply_img']['name']);
              if($img_error === 0 && $ext === '.jpg' || $ext === '.png'){

                $tweet_img = $this->Replys->Tweets->find()->where(['id' => $post['tweet_id']]);
                foreach ($tweet_img as $key) {
                  $uniq_id = $key['tweet_img'];
                }
                $img_adress = $this->Image->CreateImagePath_replys($uniq_id,$username,$user_id,$ext);
                $reply->reply_img = $img_adress;
                list($baseImage,$width,$hight) = $this->Image->images($post['reply_img']['tmp_name'],R_PROTO_IMG,$img_adress);
                $image = imagecreatetruecolor(THUMB_WIDTH, THUMB_HEIGHT);
                $this->Image->CreatTtumb($image,$baseImage,R_COMPRE_IMG,$width,$hight,$img_adress);
              }else {
                $this->Flash->error(__('The tweet could not be saved. Please, try again.'));
                return $this->redirect(['controller' => 'tweets','action' => 'view/'.$reply->tweet_id]);
              }
            }else {
              $img_error = 0;
            }

          if($img_error === 0 || $reply->reply_content){
            if ($this->Replys->save($reply)) {
              $max = $this->Replys->find()->where(['tweet_id' =>$reply->tweet_id])->count();
              $tweetsTable = $this->getTableLocator()->get('Tweets');
              $newcount = $tweetsTable->get($reply->tweet_id);
              $newcount->maxpost = $max;
              $tweetsTable->save($newcount);

              return $this->redirect(['controller' => 'tweets','action' => 'view/'.$reply->tweet_id]);
            }
          }else {
            $this->Flash->error(__('The reply could not be saved. Please, try again.'));
            return $this->redirect(['controller' => 'tweets','action' => 'view/'.$reply->tweet_id]);
          }
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
            return $this->redirect(['action' => 'index']);
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


      if(!empty($reply['reply_img'])){
        $this->Image->DeleteFile_2(R_PROTO_IMG,R_COMPRE_IMG,$reply['reply_img']);
      }

      if ($this->Replys->delete($reply)) {
        $this->Flash->success(__('The reply has been deleted.'));
        return $this->redirect(['controller' => 'tweets','action' => 'view/'.$reply->tweet_id]);
      } else {
          $this->Flash->error(__('The reply could not be deleted. Please, try again.'));
      }
      return $this->redirect(['controller' => 'tweets','action' => 'index']);
    }

    public function beforeFilter(Event $event){
      parent::beforeFilter($event);
      $this->Auth->allow(['index']);
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
