<?php
/* @var $this yii\web\View */
/* @var $model */
use yii\bootstrap4\Html;

?>
<h1 class="text-center">Выберите отчёт</h1>

<p>
<div class="row">
    <div class="col text-center">
        <?= Html::a('Заказы', ['orders'], ['class' => 'btn btn-success']) ?>
    </div>
    <div class="col text-center">
        <?= Html::a('Наличие лекарств(форма №1)', ['availability-of-goods-form-one'], ['class' => 'btn btn-success']) ?>
    </div>
    <div class="col text-center">
        <?= Html::a('Наличие лекарств(форма №2)', ['availability-of-goods-form-two'], ['class' => 'btn btn-success']) ?>
    </div>
</div>
</p>




