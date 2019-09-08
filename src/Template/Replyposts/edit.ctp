<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Replypost $replypost
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $replypost->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $replypost->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Replyposts'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Tweets'), ['controller' => 'Tweets', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tweet'), ['controller' => 'Tweets', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="replyposts form large-9 medium-8 columns content">
    <?= $this->Form->create($replypost) ?>
    <fieldset>
        <legend><?= __('Edit Replypost') ?></legend>
        <?php
            echo $this->Form->control('tweets_id', ['options' => $tweets]);
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('reply_content');
            echo $this->Form->control('reply_img');
            echo $this->Form->control('re_create_at');
            echo $this->Form->control('re_modefied');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
