<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Http\Cookie\Cookie;
use Cake\I18n\Time;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    public $components = ['Image'];

    protected function _setPassword($password)
    {
      return (new DefaultPasswordHasher)->hash($password);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            $userinfo  =  $this->request->getData();
            $this->response = $this->response->withCookie(new Cookie("username",$userinfo['username'],new Time("+5 day"),"/","",false,false));
            $this->response = $this->response->withCookie(new Cookie("password",$userinfo['password'],new Time("+5 day"),"/","",false,false));

            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Tweets','Replys']
        ]);

        //サムネイル画像表示のための画像投稿有無判定
        $this->loadModel('Replys');
        $ImagePostReply = $this->Replys->find()->where(['user_id' => $id ,'reply_img' => '0'])->count();
        $AllReplyPost = $this->Replys->find()->where(['user_id' => $id])->count();
        $this->loadModel('Tweets');
        $ImagePostTweets = $this->Tweets->find()->where(['user_id' => $id ,'image_pass' => '0'])->count();
        $AllReplyTweets = $this->Tweets->find()->where(['user_id' => $id])->count();
        $Images =  ($AllReplyPost - $ImagePostReply) + ($AllReplyTweets - $ImagePostTweets);
        $this->set(compact('Images'));

        //Youtubeサムネイル表示
        $ContentPostTweet = $this->Tweets->find()->where(['user_id' => $id]);
        $ContentPostReply = $this->Replys->find()->where(['user_id' => $id]);
        $this->set(compact('ContentPostTweet','ContentPostReply'));

        // //投稿の中からyoutubeのurlが含まれている投稿のみ取得
        foreach($ContentPostTweet as $keys ){
          if(preg_match("/https/",$keys->content) && preg_match("/youtu.be/",$keys->content)){
            if($keys->content){
              $GetVideo = 1;
            }
          }
          if(preg_match("/https/",$keys->reply_content) && preg_match("/youtu.be/",$keys->reply_content)){
            if($keys->content){
              $GetVideo2 = 1;
            }
          }
        }

        if(!empty($GetVideo) || !empty($GetVideo2)){
          $done1 = 'ok';
          $done2 = 'ok';
          $this->set(compact('done1','done2'));
        }


        $username = $this->Session->read('username');
        $user_id = $this->Session->read('user_id');
        $this->set(compact('user_id','username'));

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $userinfo = $this->request->getData();

            if(isset($userinfo['img_name']['error']) && $userinfo['img_name']['error'] === 0){
              $img_error = $userinfo['img_name']['error'];
            }else {
              $img_error = 0;
            }

            if(isset($userinfo['img_name']['name']) && $img_error === 0){
              $ext = $this->Image->CutExt_Lower($userinfo['img_name']['name']);
              if(isset($userinfo['img_name']['name']) && $userinfo['img_name']['name'] !=='' && $img_error === 0 && $ext === '.jpg' || $ext === '.png'){

                if ($user->icon !=='0.png'){
                  $this->Image->DeleteFile_2(P_COMPRE_IMG,P_PROTO_IMG,$user->icon);
                }

                $day = time();
                $img_adress =  $day.$user_id.$ext;
                $user->icon = $img_adress;

                list($baseImage,$width,$hight) = $this->Image->images($userinfo['img_name']['tmp_name'],P_PROTO_IMG,$img_adress);
                $image = imagecreatetruecolor(ICON_SIZE, ICON_SIZE); // サイズを指定して新しい画像のキャンバスを作成

                // 画像のコピーと伸縮
                $this->Image->CreatTtumb($image,$baseImage,P_COMPRE_IMG,$width,$hight,$img_adress);
              }elseif($userinfo['img_name']['name'] ===''){
                // 画像を変更しない場合はスルー
              }else {
                $this->Flash->error(__('画像のサイズが大きすぎます'));
              }
            }


            if ($this->Users->save($user)) {
              return $this->redirect(['controller' => 'users','action' => 'edit/'.$user->id]);
            }else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id, [
            'contain' => ['Tweets','Replys']
        ]);

        if($user->icon !== '0.png'){
          $file1 = WWW_ROOT.IMAGES_DIR.P_PROTO_IMG.$user->icon;
        }
        $file2 = WWW_ROOT.IMAGES_DIR.P_COMPRE_IMG.$user->icon;
        if(isset($file1) && isset($file2)){
          unlink($file1);
          unlink($file2);
        }
        $CompreImage = WWW_ROOT.IMAGES_DIR.COMPRE_IMG.$user->username;
        $ProtoImage = WWW_ROOT.IMAGES_DIR.PROTO_IMG.$user->username;
        $R_CompreImage = WWW_ROOT.IMAGES_DIR.R_COMPRE_IMG.$user->username;
        $R_ProtoImage = WWW_ROOT.IMAGES_DIR.R_PROTO_IMG.$user->username;
        $files = [$CompreImage,$ProtoImage,$R_CompreImage,$R_ProtoImage];
        foreach ($files as $file) {
          $this->Image->deletefileforeach($file);
        }

        $replysTable = $this->getTableLocator()->get('Replys');
        $userpost = $replysTable->find()->where(['user_id' => $id]);
        $tweetcount = $userpost->select(['tweet_id'])->distinct();

      //削除予定のユーザが投稿した投稿数と削除予定ユーザー以外が投稿した投稿数をそれぞれ検索
      foreach ($tweetcount as $key) {
        $count[] = $key->tweet_id;
        $allposts = $replysTable->find()->where(['tweet_id' => $key->tweet_id])->count();
        $AllPosts[] = $allposts;
        $userposts = $replysTable->find()->where(['tweet_id' => $key->tweet_id ,'user_id' => $id])->count();
        $UserPosts[] = $userposts;
        $n =  count($AllPosts);
      }

      //投稿数の変更処理
      if(isset($UserPosts) && $UserPosts !==NULL){
        for ($i=0; $i < $n; $i++) {
          $result[] = ($AllPosts[$i] - $UserPosts[$i]);
          $tweetsTable = $this->getTableLocator()->get('Tweets');
          $newcount = $tweetsTable->get($count[$i]);
          $newcount->maxpost = $result[$i];
          $tweetsTable->save($newcount);
        }
      }


      if ($this->Users->delete($user)) {
        $this->Flash->success(__('The user has been deleted.'));
        $this->request->getSession()->destroy();
        return $this->redirect(['action' => 'add']);
      } else {
          $this->Flash->error(__('The user could not be deleted. Please, try again.'));
      }
        return $this->redirect(['controller' => 'users','action' => 'index']);
    }


    public function login()
    {
      $username = $this->request->getCookie('username');
      $password = $this->request->getCookie('password');
      $this->set(compact('username','password'));
      // $this->response = $this->response->withExpiredCookie(new Cookie("username"));
      // $this->response = $this->response->withExpiredCookie(new Cookie("password"));

      if($this->request->isPost()){
        $user = $this->Auth->identify();
        if(!empty($user)){
          $this->Auth->setUser($user);

          $this->Session->write(['username' => $user['username'],'user_id' => $user['id']]);
          $username = $this->Session->read('username');
          $user_id = $this->Session->read('user_id');
          $this->set(compact('username','user_id'));

          // $userinf = $this->request->getData();
          // $this->response = $this->response->withCookie(new Cookie("usernames",$userinf['username'],new Time("+5 day"),"/","",false,false));
          // $this->response = $this->response->withCookie(new Cookie("passwords",$userinf['password'],new Time("+5 day"),"/","",false,false));
          // $usernames = $this->request->getCookie('usernames');
          // $passwords = $this->request->getCookie('passwords');
          // $this->set(compact('usernames','passwords'));


          $this->Flash->success(__('ログイン成功！'));
          return $this->redirect($this->Auth->redirectUrl());
        }else {
          $this->Flash->error('ユーザー名かパスワードが間違っています');
        }
      }
    }

    public function logout()
    {
      $this->response = $this->response->withExpiredCookie(new Cookie("username"));
      $this->response = $this->response->withExpiredCookie(new Cookie("password"));
      $this->request->getSession()->destroy();
    }

    public function beforeFilter(Event $event)
    {
      parent::beforeFilter($event);
      $this->Auth->allow(['add','logout','edit']);
    }

    public function isAuthorized($user = null)
    {
      $action = $this->request->getParam(['action']);

      if(in_array($action,['view'])){
        return true;
      }

      if($user['role'] === 'user'){
        return true;
      }
    }

}
