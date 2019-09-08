<div class="InsertFormSection">
  <div class="InsertFormBox">
    <h2>ログイン画面</h2>
    <?= $this->Form->create() ?>
    <?= $this->Form->control('username',['label' => 'アカウント名']); ?>
    <?= $this->Form->control('password',['label' => 'パスワード']); ?>
    <?= $this->Form->submit(' 送 信 ',['class' => 'reset SubmitButton']) ?>
    <?= $this->Form->end() ?>
  </div>
</div>
