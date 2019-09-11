<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->script('https://kit.fontawesome.com/c2064407e9.js') ?>
    <?= $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js') ?>
    <?= $this->Html->script('main.js') ?>
    <?= $this->Html->script('slick.min.js') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('main.css') ?>
    <?= $this->Html->css('slick-theme.css') ?>
    <?= $this->Html->css('slick.css') ?>

</head>
<body>
    <?= $this->Flash->render() ?>
    <?= $this->element('my_header') ?>
    <div class="container ">
        <?= $this->fetch('content') ?>
    </div>
    <?= $this->element('my_footer') ?>
</body>
</html>
