<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Reply $reply
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $reply->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $reply->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Replys'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Tweets'), ['controller' => 'Tweets', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tweet'), ['controller' => 'Tweets', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="replys form large-9 medium-8 columns content">
    <?= $this->Form->create($reply) ?>
    <fieldset>
        <legend><?= __('Edit Reply') ?></legend>
        <?php
            echo $this->Form->control('tweet_id', ['options' => $tweets]);
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('reply_content');
            echo $this->Form->control('reply_img');
            echo $this->Form->control('create_at', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
