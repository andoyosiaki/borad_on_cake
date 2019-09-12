<main>
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
        <p><?php list($AnchorUrl,$YoutubeUrl,$ImageUrl,$YoutubeTitle) = $this->Link->CreateLink($tweet->content); ?></p>
        <p class="MainPost"><?= nl2br($AnchorUrl); ?></p>
        <?php if(isset($YoutubeUrl)): ?>
        <p class='YoutubeTitle'><a href="<?= $YoutubeUrl ?>"><?= $YoutubeTitle ?></a></p>
        <div class="MainYoutubeBox">
          <p><a target="_blank" href="<?= $YoutubeUrl ?>" target="_blank"><img src="<?= $ImageUrl; ?>" class="MainYoutubeImage"></a></p>
        </div>
        <?php endif; ?>
      </div>
      <?php if($tweet->image_pass): ?>
      <div class="MainPostImageBox">
      <?= $this->Html->image(COMPRE_IMG.$tweet->image_pass,['class' => 'MainPostImage','url'=>['action' => 'image',$tweet->id]]); ?>
      </div>
      <?php endif; ?>
    </div>
  </article>
</main>

<main>
<?php foreach($result as $tweets): ?>
  <article class="MainArticle">
    <div class="MainIconBox">
      <?= $this->Html->image(P_COMPRE_IMG.$tweets->user->icon,['class' => 'MinIcon','url' => ['controller' => 'users','action' => 'edit',$tweets->user->id]]) ?>
    </div>
    <div class="MainAuthorPostBox">
      <div class="MainAuthorName">
        <div class="NameBox">
        <?= $this->Html->link($tweets->user->username,['controller' => 'users','action' => 'edit',$tweets->user->id]) ?>
        </div>
        <div class="TimeBox">
        <time><?= $tweets['create_at']; ?></time>
        </div>
      </div>
      <div class="MainPostBox">
        <p><?php list($AnchorUrl,$YoutubeUrl,$ImageUrl,$YoutubeTitle) = $this->Link->CreateLink($tweets->reply_content); ?></p>
        <p class="MainPost"><?= nl2br($AnchorUrl); ?></p>
        <?php if(isset($YoutubeUrl)): ?>
        <p class='YoutubeTitle'><a href="<?= $YoutubeUrl ?>" target="_blank"><?= $YoutubeTitle ?></a></p>
        <div class="MainYoutubeBox">
          <p><a target="_blank" href="<?= $YoutubeUrl ?>"><img src="<?= $ImageUrl ?>" class="MainYoutubeImage"></a></p>
        </div>
        <?php endif; ?>
      </div>
      <?php if($tweets->reply_img): ?>
      <div class="MainPostImageBox">
      <?= $this->Html->image(R_COMPRE_IMG.$tweets->reply_img,['class' => 'MainPostImage','url'=>['controller' => 'replys','action' => 'image',$tweets->id]]); ?>
      </div>
      <?php endif; ?>
      <div class="TinkerBox">
        <?php if($username === $tweets->user->username): ?>
        <div class="DeleteIconBox">
        <?= $this->Form->postLink('',['controller' => 'replys','action' => 'delete',$tweets->id],['confirm'=>'Are you sure?']); ?>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </article>
<?php endforeach; ?>
</main>
<div class="TweetPostSection">
  <?php if($username): ?>
  <div class="TweetPostFormBox">
    <?= $this->Form->create('replys',['enctype' => 'multipart/form-data','url' => ['controller' => 'Replys','action' => 'add']]) ?>
    <?= $this->Form->textarea('reply_content',['placeholder'=>'投稿内容は200文字以下で,画像は2M以下の.jpgか.pngのみUPできます。']) ?>
    <label for="File" id="LabelFile"><i class="far fa-image fa-2x "></i></label>
    <?= $this->Form->hidden('MAX_FILE_SIZE',['value' => MAX_FILE_SIZE]) ?>
    <?= $this->Form->control('reply_img',['label' => false,'type' => 'file','id' => 'File','accept'=>'.jpg,.png']) ?>
    <?= $this->Form->hidden('tweet_id',['value' => $tweet->id ]) ?>
    <?= $this->Form->submit(' 送 信 ',['class' => 'reset PostButton']) ?>
    <?= $this->Form->end() ?>
  </div>
  <?php elseif(empty($username)): ?>
  <div class="InductionLoginBox">
    <p>ログインすると投稿可能になります。</p>
    <div class="Induction">
      <?= $this->Html->link('Login',['controller'=>'users','action'=>'login']) ?>
      <?= $this->Html->link('Register',['controller'=>'users','action'=>'add']) ?>
    </div>
  </div>
  <?php endif; ?>
</div>
