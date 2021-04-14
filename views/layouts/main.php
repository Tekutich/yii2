<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\models\User;
use app\widgets\Alert;


use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

use yii\helpers\Html;

use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Аптечка',
        'brandUrl' => '/drugs/index',
        'options' => [
            'class' => 'navbar-dark bg-dark navbar-expand-lg ',
        ],

    ]);
    echo Nav::widget([

        'options' => ['class' => 'navbar-nav ml-auto'],
        'items' => array_merge([
            ['options' => ['class' => 'nav-item mx-auto pr-3'], 'label' => 'Каталог', 'url' => ['/drugs/index']],
            ['options' => ['class' => 'nav-item mx-auto pr-3'], 'label' => 'Корзина', 'url' => ['/cart/index']],
        ], Yii::$app->user->isGuest ? [
            ['label' => 'Вход', 'url' => ['/site/login']]
        ] : array_merge(
            User::isUserAdmin(Yii::$app->user->identity->email) ?
                [['options' => ['class' => 'nav-item mx-auto pr-3'],'label' => 'Пользователи', 'url' => ['/users/index']], ['options' => ['class' => 'nav-item mx-auto pr-3'],'label' => 'Заказы', 'url' => ['/orders/index']]] :
                [['options' => ['class' => 'nav-item mx-auto pr-3'],'label' => 'Заказы', 'url' => ['/user-orders/index']]],
            [
                "<li class='nav-item mx-auto pr-3'>"
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Выход (' . Yii::$app->user->identity->email . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            ]
        ))

    ]);
    NavBar::end();
    ?>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'homeLink' => [
                'label' => 'Главная',
                'url' => '/drugs/index'
            ]
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer ">
    <div class="container">
        <p class="">&copy; My Company <?= date('Y') ?>. <?= Yii::powered() ?></p>


    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
