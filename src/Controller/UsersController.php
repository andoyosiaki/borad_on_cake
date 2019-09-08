<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Auth\DefaultPasswordHasher;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

      protected function _setPassword($password)
    {
      return (new DefaultPasswordHasher)->hash($password);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Replys', 'Tweets']
        ]);

        $this->set('user', $user);
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

        //画像が投稿されてるか判定
        foreach ($user->tweets as $key){ $image = $key->image_pass;}
        foreach ($user->replys as $key){ $image = $key->reply_img;}
        $this->set(compact('image'));

        $username = $this->Session->read('username');
        $user_id = $this->Session->read('user_id');
        $this->set(compact('user_id','username'));


        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $userinfo = $this->request->getData();
            $img_error = $userinfo['img_name']['error'];
            $ext = $this->_CutExt_Lower($userinfo['img_name']['name']);
            if($userinfo['img_name']['name'] !=='' && $img_error === 0 && $ext === '.jpg' || $ext === '.png'){

              if ($user->icon !=='0.png'){
                $this->_DeleteFile_2(P_COMPRE_IMG,P_PROTO_IMG,$user->icon);
              }

              $day = time();
              $img_adress =  $day.$user_id.$ext;
              $user->icon = $img_adress;

              list($baseImage,$width,$hight) = $this->_images($userinfo['img_name']['tmp_name'],P_PROTO_IMG,$img_adress);
              $image = imagecreatetruecolor(ICON_SIZE, ICON_SIZE); // サイズを指定して新しい画像のキャンバスを作成

              // 画像のコピーと伸縮
              $this->_CreatTtumb($image,$baseImage,P_COMPRE_IMG,$width,$hight,$img_adress);
            }elseif($userinfo['img_name']['name'] ===''){
              // 画像を変更しない場合はスルー
            }else {
              $this->Flash->error(__('画像のサイズが大きすぎます'));
            }


            if ($this->Users->save($user)) {

                return $this->redirect(['controller' => 'users','action' => 'edit/'.$user->id]);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
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
          $this->_deletefileforeach($file);
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
      for ($i=0; $i < $n; $i++) {
        $result[] = ($AllPosts[$i] - $UserPosts[$i]);
        $tweetsTable = $this->getTableLocator()->get('Tweets');
        $newcount = $tweetsTable->get($count[$i]);
        $newcount->maxpost = $result[$i];
        $tweetsTable->save($newcount);
      }

      if ($this->Users->delete($user)) {
          $this->Flash->success(__('The user has been deleted.'));
          $this->request->session()->destroy();
      } else {
          $this->Flash->error(__('The user could not be deleted. Please, try again.'));
      }
        return $this->redirect(['controller' => 'users','action' => 'index']);
    }



    public function login()
    {
      if($this->request->isPost()){
        $user = $this->Auth->identify();

        if(!empty($user)){
          $this->Auth->setUser($user);

          $this->Session->write(['username' => $user['username'],'user_id' => $user['id']]);
          $username = $this->Session->read('username');
          $user_id = $this->Session->read('user_id');
          $this->set(compact('userid','user_id'));

          return $this->redirect($this->Auth->redirectUrl());

        }else {
          $this->Flash->error('ユーザー名かパスワードが間違っています');
        }

      }
    }

    public function logout()
    {
    $this->request->session()->destroy();
    return $this->redirect($this->Auth->logout());
    }

    public function beforeFilter(Event $event)
    {
      parent::beforeFilter($event);
      $this->Auth->allow(['index','add']);
    }

    public function isAuthorized($user = null)
    {
      $action = $this->request->parames['action'];

        if(in_array($action,['view'])){
        return true;
      }

      if($user['role'] === 'user'){
        return true;
      }
    }

    public function _DeleteFile_2($dir1,$dir2,$data){
      $file1 = WWW_ROOT.IMAGES_DIR.$dir1.$data;
      $file2 = WWW_ROOT.IMAGES_DIR.$dir2.$data;
      unlink($file1);
      unlink($file2);
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

    public function _deletefileforeach($filepass){
      foreach(glob($filepass.'*') as $filepass){
        unlink($filepass);
      }
    }

}
