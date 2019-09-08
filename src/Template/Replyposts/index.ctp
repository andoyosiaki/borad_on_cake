<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Replypost[]|\Cake\Collection\CollectionInterface $replyposts
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Replypost'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tweets'), ['controller' => 'Tweets', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tweet'), ['controller' => 'Tweets', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="replyposts index large-9 medium-8 columns content">
    <h3><?= __('Replyposts') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tweets_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('reply_img') ?></th>
                <th scope="col"><?= $this->Paginator->sort('re_create_at') ?></th>
                <th scope="col"><?= $this->Paginator->sort('re_modefied') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($replyposts as $replypost): ?>
            <tr>
                <td><?= $this->Number->format($replypost->id) ?></td>
                <td><?= $replypost->has('tweet') ? $this->Html->link($replypost->tweet->id, ['controller' => 'Tweets', 'action' => 'view', $replypost->tweet->id]) : '' ?></td>
                <td><?= $replypost->has('user') ? $this->Html->link($replypost->user->id, ['controller' => 'Users', 'action' => 'view', $replypost->user->id]) : '' ?></td>
                <td><?= h($replypost->reply_img) ?></td>
                <td><?= h($replypost->re_create_at) ?></td>
                <td><?= h($replypost->re_modefied) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $replypost->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $replypost->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $replypost->id], ['confirm' => __('Are you sure you want to delete # {0}?', $replypost->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
