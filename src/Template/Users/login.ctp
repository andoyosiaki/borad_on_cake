<div class="InsertFormSection">
  <div class="InsertFormBox">
    <h2>ログイン画面</h2>
    <?= $this->Form->create() ?>
    <?= $this->Form->control('username'); ?>
    <?= $this->Form->control('password'); ?>
    <?= $this->Form->submit('送信') ?>
    <?= $this->Form->end() ?>
  </div>
</div>
