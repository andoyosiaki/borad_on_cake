<div class="InsertFormSection">
  <div class="InsertFormBox">
    <h2>ログイン画面</h2>
    <?= $this->Form->create() ?>
    <?= $this->Form->control('username',['value' => $username]); ?>
    <?= $this->Form->control('password',['value' => $password]); ?>
    <?= $this->Form->submit(' 送 信 ',['class' => 'reset SubmitButton']) ?>
    <?= $this->Form->end() ?>
  </div>
</div>
