
<div class="TweetPostSection_SerchWrap">
  <div class="TweetPostSection_SerchBox">
  <?= $this->Form->create('text',['action' => 'serch']); ?>
  <?= $this->Form->control('data[replys]',['label' => false,'placeholder' => '投稿検索','class' => 'FormLabel']); ?>
  <?= $this->Form->end(); ?>
  </div>
</div>

<div class="TweetPostSection">
  <div class="SerchForm_TriggerBox">
  <a href="#" id="SerchFormTrigger"><i class="fas fa-search"></i>投稿検索</a>
  </div>
  <?php if($username): ?>
  <?= $this->element('how_to_post_youtube') ?>
  <div class="TweetPostFormBox">
    <?= $this->Form->create('tweets',['type' => 'file','url'=>['action' => 'add']]) ?>
    <label class="radioIntro">あなたの投稿に他ユーザーからの返信を許可するか選べます</label>
    <div class="radio">
    <?= $this->Form->radio('restriction',['opend' => '　書き込みを許可する。','closed' => '　書き込みを許可しない'],['value'=>'opend']) ?>
    </div>
    <?= $this->Form->textarea('content',['class' => 'Textarea','placeholder'=>'投稿内容は200文字以下で,画像は'.$this->Link->CutIntFromImagesize(MAX_FILE_SIZE).'M以下の.jpgか.pngのみUPできます。']) ?>
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
      <?= $this->Html->link('Signin',['controller'=>'users','action'=>'login'],['class' => 'AnchorButton_Login']) ?>
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
        <?php list($AnchorUrl,$YoutubeUrl,$ImageUrl,$YoutubeTitle) = $this->Link->CreateLink($tweet->content); ?>
        <p class="MainPost"><?= nl2br($AnchorUrl); ?></p>
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
        <?php if($tweet->maxpost > 0): ?><div class="MaxReplayPost"><?php $tweet->maxpost; ?></div><?php endif; ?>
        <div class="RestrictionBox">
        <?php if($tweet->restriction === 'opend'){ ?><div class="Opend"><span>制限無し</span></div><?php } elseif($tweet->restriction === 'closed'){ ?><div class="Closed"><span>制限有り</span></div><?php } ?>
        </div>
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
