<div class="InsertFormSection">
  <div class="InsertFormBox">
    <h2>会員登録画面</h2>
    <?= $this->Form->create(); ?>
    <?= $this->Form->control('username'); ?>
    <p class="text-muted">アカウント名は半角英数文字の10文字以下でお願いします。</p>
    <?= $this->Form->control('password'); ?>
    <p class="text-muted">パスワードは半角英数字で４文字以上でお願いします。</p>
    <?= $this->Form->hidden('icon',['value'=>'0.png']); ?>
    <?= $this->Form->hidden('role',['value'=>'user']); ?>
    <?= $this->Form->submit('送信');?>
    <?= $this->Form->end(); ?>
  </div>
</div>
