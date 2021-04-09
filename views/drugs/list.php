<?php

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

/** @var TYPE_NAME $model */

$bundle = AppAsset::register($this);
?>

<img class="img-fluid mx-auto d-block img-product" src="<?= $bundle->baseUrl ?>/images/tabletki.png" alt="">
<div class="text-center">
    <p class="name-product"><?= HtmlPurifier::process($model->trade_name) ?></p>
    <p> <?= Html::a('Посмотреть', ['drugs/product', 'id' => $model->id], ['class' => 'btn btn-primary']); ?></p>
</div>