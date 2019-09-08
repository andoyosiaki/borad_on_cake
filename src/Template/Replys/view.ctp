<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Reply $reply
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Reply'), ['action' => 'edit', $reply->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Reply'), ['action' => 'delete', $reply->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reply->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Replys'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reply'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tweets'), ['controller' => 'Tweets', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tweet'), ['controller' => 'Tweets', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="replys view large-9 medium-8 columns content">
    <h3><?= h($reply->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Tweet') ?></th>
            <td><?= $reply->has('tweet') ? $this->Html->link($reply->tweet->id, ['controller' => 'Tweets', 'action' => 'view', $reply->tweet->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $reply->has('user') ? $this->Html->link($reply->user->id, ['controller' => 'Users', 'action' => 'view', $reply->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Reply Img') ?></th>
            <td><?= h($reply->reply_img) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($reply->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Create At') ?></th>
            <td><?= h($reply->create_at) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Reply Content') ?></h4>
        <?= $this->Text->autoParagraph(h($reply->reply_content)); ?>
    </div>
</div>
