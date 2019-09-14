<header>
  <nav class="Navigation">
    <div class="NavigationBox">
      <div class="NavigationBrandBox">
        <h1 class="NavigationBrandTitle"><?= $this->Html->link('画像掲示板',['controller'=>'tweets','action'=>'index']) ?></h1>
      </div>
      <ul class="NavigationList">
        <?php if(isset($user_id)): ?><li class="NavigationItems" id="Mypage"><?= $this->Html->link('Mypage',['controller' => 'users','action' => 'edit',$user_id]) ?></li><?php endif; ?>
        <li class="NavigationItems" id="Signin"><?= $this->Html->link('Signin',['controller'=>'users','action'=>'login']) ?></li>
        <?php if(isset($user_id)): ?><li class="NavigationItems" id="Signout"><?= $this->Html->link('Signout',['controller'=>'users','action'=>'logout']) ?></li><?php endif; ?>
        <li class="NavigationItems" id="Register"><?= $this->Html->link('Register',['controller'=>'users','action'=>'add']) ?></li>
      </ul>
    </div>
  </nav>
</header>
