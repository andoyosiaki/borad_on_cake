<!-- <?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Replys'), ['controller' => 'Replys', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reply'), ['controller' => 'Replys', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tweets'), ['controller' => 'Tweets', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tweet'), ['controller' => 'Tweets', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Icon') ?></th>
            <td><?= h($user->icon) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Role') ?></th>
            <td><?= h($user->role) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Username') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Password') ?></th>
            <td><?= h($user->password) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Introduction') ?></h4>
        <?= $this->Text->autoParagraph(h($user->introduction)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Replys') ?></h4>
        <?php if (!empty($user->replys)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Tweet Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Reply Content') ?></th>
                <th scope="col"><?= __('Reply Img') ?></th>
                <th scope="col"><?= __('Create At') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->replys as $replys): ?>
            <tr>
                <td><?= h($replys->id) ?></td>
                <td><?= h($replys->tweet_id) ?></td>
                <td><?= h($replys->user_id) ?></td>
                <td><?= h($replys->reply_content) ?></td>
                <td><?= h($replys->reply_img) ?></td>
                <td><?= h($replys->create_at) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Replys', 'action' => 'view', $replys->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Replys', 'action' => 'edit', $replys->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Replys', 'action' => 'delete', $replys->id], ['confirm' => __('Are you sure you want to delete # {0}?', $replys->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Tweets') ?></h4>
        <?php if (!empty($user->tweets)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Image Pass') ?></th>
                <th scope="col"><?= __('Content') ?></th>
                <th scope="col"><?= __('Tweet Img') ?></th>
                <th scope="col"><?= __('Maxpost') ?></th>
                <th scope="col"><?= __('Create At') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->tweets as $tweets): ?>
            <tr>
                <td><?= h($tweets->id) ?></td>
                <td><?= h($tweets->user_id) ?></td>
                <td><?= h($tweets->image_pass) ?></td>
                <td><?= h($tweets->content) ?></td>
                <td><?= h($tweets->tweet_img) ?></td>
                <td><?= h($tweets->maxpost) ?></td>
                <td><?= h($tweets->create_at) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Tweets', 'action' => 'view', $tweets->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Tweets', 'action' => 'edit', $tweets->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Tweets', 'action' => 'delete', $tweets->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tweets->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div> -->
