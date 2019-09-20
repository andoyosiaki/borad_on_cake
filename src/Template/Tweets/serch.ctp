<div class="FormSerch_CountSection">
<p>検索結果:<?=$count ?>件</p>
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
