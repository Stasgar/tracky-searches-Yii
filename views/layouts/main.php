<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<html prefix="og: http://ogp.me/ns#">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:image" content="https://tracky-searches.ru/images/preview.png">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '<div class="logo-block">'.Html::img('/images/logo_img.png', ['width' => '25px', 'class' => 'icon pull-left']).'<span class="logo-1-part">Tracky</span><span class="logo-2-part"> searches</span></div>',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-default navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels'=>false,
        'items' => [
            ['label' => '<span class="glyphicon glyphicon-search"></span> Отследить', 'url' => ['/tracking/default/index']],
            ['label' => '<span class="glyphicon glyphicon-info-sign"></span> О нас', 'url' => ['/site/about']],
            Yii::$app -> user -> isGuest ? (
                ['label' => '<span class="glyphicon glyphicon-log-in"></span> Регистрация/Вход', 'url' => ['/auth/authorization/authorize']]
            ) : (
                [
                'label' => '<span class="glyphicon glyphicon-user"></span> ' . Html::encode(Yii::$app->user->identity->user_name)  .' ' . Html::showUserAvatar(22),
                    'items' => [
                        ['label' => '<span class="glyphicon glyphicon-user"></span> Мой аккаунт' , 'url' => ['/user/default/user-info']],
                        Yii::$app->user->can('viewAdminPage') ? (
                        ['label' => '<span class="glyphicon glyphicon-list-alt"></span> Админ-панель' , 'url' => ['/admin']] ):('' ),
                        ['label' => '<span class="glyphicon glyphicon-log-out"></span> Выход' , 'url' => ['/auth/authorization/logout']],

                    ],
                ]
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p style="color:#6C8298" class="pull-left">&copy; Tracky-searches 2016-<?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
