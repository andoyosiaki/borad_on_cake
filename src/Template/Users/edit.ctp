<?php if(isset($image)): ?>
<div class="ImageSectionWrap">
  <div class="innerwrap">
    <div class="ImageSection">
      <div class="ImageSection_Title">
        <p>-- 投稿画像一覧 --</p>
      </div>
      <ul class="slider">
      <?php foreach($user->replys as $tweet): ?>
          <?php if($tweet->reply_img === '0'){
          }elseif($tweet->reply_img !== '0'){
            ?><li><?php if(isset($tweet->reply_img)){ echo $this->Html->image(R_COMPRE_IMG.$tweet->reply_img,['class' => 'MainPostImage','url'=>['controller' => 'replys','action' => 'image',$tweet->id]]);} ?> </li> <?php } ?>
      <?php endforeach; ?>
      <?php foreach($user->tweets as $tweet): ?>
        <?php if($tweet->image_pass === null) {
        }elseif($tweet->image_pass !== null){
          ?><li> <?php if(isset($tweet->image_pass)){ echo $this->Html->image(COMPRE_IMG.$tweet->image_pass,['class' => 'MainPostImage','url'=>['controller' => 'tweets','action' => 'image',$tweet->id]]);} ?></li><?php } ?>
      <?php endforeach; ?>
      </ul>
    </div>
  </div>
</div>
<?php endif; ?>

<div class="ProfileSectionWrapper">
  <div class="ProfileSection">
    <div class="ProfileBox">
      <div class="ProfileInnerBox">
        <div class="UserIconBox">
          <?php if($user->icon === '0.png'): ?>
          <p class="m-1"><?= $this->Html->image(P_COMPRE_IMG.'0.png',['class' => 'UserIcon']); ?></p>
          <?php else: ?>
          <p class="m-1"><?= $this->Html->image(P_COMPRE_IMG.$user->icon,['class' => 'UserIcon']) ?></p>
          <?php endif; ?>
          <p class="UserName"><?= $user->username; ?></p>
        </div>
        <div class="S-IntoroductionBox">
          <?php if($user->introduction === null): ?>
          <p>「プロフィールを編集する」から自己紹介文とアイコンを作成してください。</p>
          <?php endif; ?>
          <p><?= nl2br(h($user->introduction)); ?></p>
        </div>
      </div>
      <?php if($user_id === $user->id): ?>
      <div class="ProfileEditTriggerBox">
        <button type="button" class="ProfileEditTrigger">プロフィールを編集する</button>
      </div>
      <div class="ProfileEditBox">
        <?= $this->Form->create('users',['action' => 'edit/'.$user->id,'enctype' => 'multipart/form-data']) ?>
        <?= $this->Form->textarea('introduction',['class' => 'Profile','placeholder' => '自己紹介','value' => $user->introduction]) ?>
        <div class="file">
          <label for="File" id="LabelFile"><i class="far fa-smile fa-2x"></i></label>
          <?= $this->Form->hidden('MAX_FILE_SIZE',['value' => MAX_FILE_SIZE]) ?>
          <?= $this->Form->control('img_name',['type' => 'file','id' => 'File','accept'=>'.jpg,.png']) ?>
          <?= $this->Form->submit('送信') ?>
          <?= $this->Form->end() ?>
        </div>
        <div class="DeleteBox">
          <?= $this->Form->postLink('退会する',['id' => 'delete','action' => 'delete',$user->id],['confirm'=>'Are you sure?']); ?>
        </div>
      </div>
    </div>
      <?php endif; ?>
  </div>
</div>

<main>
  <?php foreach($user->tweets as $tweet): ?>
  <article class="MainArticle">
    <div class="MainIconBox">
      <?= $this->Html->image(P_COMPRE_IMG.$user->icon,['class' => 'MinIcon','url' => ['controller' => 'users','action' => 'edit',$user->id]]) ?>
    </div>
    <div class="MainAuthorPostBox">
      <div class="MainAuthorName">
        <div class="NameBox">
        <?= $this->Html->link($user->username,['controller' => 'users','action' => 'edit',$user->id]) ?>
        </div>
        <div class="TimeBox">
        <time><?= $tweet['create_at']; ?></time>
        </div>
      </div>
      <div class="MainPostBox">
        <p class="MainPost"><?= nl2br(h($tweet->content)); ?></p>
      </div>
      <?php if($tweet->image_pass): ?>
      <div class="MainPostImageBox">
      <?= $this->Html->image(COMPRE_IMG.$tweet->image_pass,['class' => 'MainPostImage','url'=>['controller' => 'tweets','action' => 'image',$tweet->id]]); ?>
      </div>
      <?php endif; ?>
      <div class="TinkerBox">
        <?php if($username === $user->username): ?>
        <div class="DeleteIconBox">
        <?= $this->Form->postLink('',['controller' => 'tweets','action' => 'delete',$tweet->id],['confirm'=>'Are you sure?']); ?>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </article>
  <?php endforeach; ?>
</main>
