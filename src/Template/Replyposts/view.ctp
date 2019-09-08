<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Replypost $replypost
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Replypost'), ['action' => 'edit', $replypost->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Replypost'), ['action' => 'delete', $replypost->id], ['confirm' => __('Are you sure you want to delete # {0}?', $replypost->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Replyposts'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Replypost'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tweets'), ['controller' => 'Tweets', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tweet'), ['controller' => 'Tweets', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="replyposts view large-9 medium-8 columns content">
    <h3><?= h($replypost->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Tweet') ?></th>
            <td><?= $replypost->has('tweet') ? $this->Html->link($replypost->tweet->id, ['controller' => 'Tweets', 'action' => 'view', $replypost->tweet->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $replypost->has('user') ? $this->Html->link($replypost->user->id, ['controller' => 'Users', 'action' => 'view', $replypost->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Reply Img') ?></th>
            <td><?= h($replypost->reply_img) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($replypost->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Re Create At') ?></th>
            <td><?= h($replypost->re_create_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Re Modefied') ?></th>
            <td><?= h($replypost->re_modefied) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Reply Content') ?></h4>
        <?= $this->Text->autoParagraph(h($replypost->reply_content)); ?>
    </div>
</div>
