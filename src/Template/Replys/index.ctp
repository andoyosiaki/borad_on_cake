<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Reply[]|\Cake\Collection\CollectionInterface $replys
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Reply'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tweets'), ['controller' => 'Tweets', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tweet'), ['controller' => 'Tweets', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="replys index large-9 medium-8 columns content">
    <h3><?= __('Replys') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tweet_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('reply_img') ?></th>
                <th scope="col"><?= $this->Paginator->sort('create_at') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($replys as $reply): ?>
            <tr>
                <td><?= $this->Number->format($reply->id) ?></td>
                <td><?= $reply->has('tweet') ? $this->Html->link($reply->tweet->id, ['controller' => 'Tweets', 'action' => 'view', $reply->tweet->id]) : '' ?></td>
                <td><?= $reply->has('user') ? $this->Html->link($reply->user->id, ['controller' => 'Users', 'action' => 'view', $reply->user->id]) : '' ?></td>
                <td><?= h($reply->reply_img) ?></td>
                <td><?= h($reply->create_at) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $reply->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $reply->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $reply->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reply->id)]) ?>
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
