<div class="TweetPostSection">
  <?php if($username): ?>
  <div class="TweetPostFormBox">
    <?= $this->Form->create('tweets',['action'=>'add','enctype' => 'multipart/form-data']) ?>
    <?= $this->Form->textarea('content',['placeholder'=>'投稿内容は200文字以下で,画像は2M以下の.jpgか.pngのみUPできます。']) ?>
    <?= $this->Form->error('content') ?>
    <label for="File" id="LabelFile"><i class="far fa-image fa-2x "></i></label>
    <?= $this->Form->hidden('MAX_FILE_SIZE',['value' => MAX_FILE_SIZE]) ?>
    <?= $this->Form->control('img_name',['label' => false,'type' => 'file','id' => 'File','accept'=>'.jpg,.png']) ?>
    <?= $this->Form->submit(' 送 信 ',['class' => 'reset PostButton']) ?>
    <?= $this->Form->end() ?>
  </div>
  <?php elseif(empty($username)): ?>
  <div class="InductionLoginBox">
    <p>ログインすると投稿可能になります。</p>
    <div class="Induction">
      <?= $this->Html->link('Login',['controller'=>'users','action'=>'login'],['class' => 'AnchorButton_Login']) ?>
      <?= $this->Html->link('Register',['controller'=>'users','action'=>'add'],['class' => 'AnchorButton_Register']) ?>
    </div>
  </div>
  <?php endif; ?>
</div>

<main>
<?php foreach($tweets as $tweet): ?>
  <article class="MainArticle">
    <div class="MainIconBox">
      <?= $this->Html->image(P_COMPRE_IMG.$tweet->user->icon,['class' => 'MinIcon','url' => ['controller' => 'users','action' => 'edit',$tweet->user->id]]) ?>
    </div>
    <div class="MainAuthorPostBox">
      <div class="MainAuthorName">
        <div class="NameBox">
        <?= $this->Html->link($tweet->user->username,['controller' => 'users','action' => 'edit',$tweet->user->id]) ?>
        </div>
        <div class="TimeBox">
        <time><?= $tweet['create_at']; ?></time>
        </div>
      </div>
      <div class="MainPostBox">
        <p class="MainPost"><?php list($AnchorUrl,$YoutubeUrl,$ImageUrl,$YoutubeTitle) = $this->Link->CreateLink($tweet->content); ?></p>
        <p><?= nl2br($AnchorUrl); ?></p>
        <?php if(isset($YoutubeUrl)): ?>
        <p class='YoutubeTitle'><a href="<?= $YoutubeUrl ?>" target="_blank"><?= $YoutubeTitle ?></a></p>
        <div class="MainYoutubeBox">
          <p><a target="_blank" href="<?= $YoutubeUrl ?>"><img src="<?= $ImageUrl ?>" class="MainYoutubeImage"></a></p>
        </div>
        <?php endif; ?>
      </div>
      <?php if($tweet->image_pass): ?>
      <div class="MainPostImageBox">
      <?= $this->Html->image(COMPRE_IMG.$tweet->image_pass,['class' => 'MainPostImage','url'=>['action' => 'image',$tweet->id]]); ?>
      </div>
      <?php endif; ?>
      <div class="TinkerBox">
        <div class="ReplyIconBox">
        <?= $this->Html->link('',['controller' => 'tweets','action' =>'view',$tweet->id]) ?>
        <?php if($tweet->maxpost > 0){ echo $tweet->maxpost;} ?>
        </div>
        <?php if($tweet->maxpost > 0): ?><span class="MaxReplayPost"><?php $tweet->maxpost; ?></span><?php endif; ?>
        <?php if($username === $tweet->user->username): ?>
        <div class="DeleteIconBox">
        <?= $this->Form->postLink('',['action' => 'delete',$tweet->id],['confirm'=>'削除しますか?']); ?>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </article>
<?php endforeach; ?>
</main>
