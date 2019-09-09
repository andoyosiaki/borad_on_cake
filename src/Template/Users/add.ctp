<div class="InsertFormSection">
  <div class="InsertFormBox">
    <h2>会員登録画面</h2>
    <?= $this->Form->create($user); ?>
    <?= $this->Form->control('username',['label' => 'アカウント名']); ?>
    <p class="text-muted">アカウント名は半角英数文字の10文字以下でお願いします。</p>
    <?= $this->Form->control('password',['label' => 'パスワード']); ?>
    <p class="text-muted">パスワードは半角英数字で４文字以上でお願いします。</p>
    <?= $this->Form->hidden('icon',['value'=>'0.png']); ?>
    <?= $this->Form->hidden('role',['value'=>'user']); ?>
    <?= $this->Form->submit(' 送 信 ',['class' => 'reset SubmitButton']);?>
    <?= $this->Form->end(); ?>
  </div>
</div>
