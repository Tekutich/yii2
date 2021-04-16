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
        <?= Html::a('Наличие лекарств(таблица)', ['balance-of-goods-table'], ['class' => 'btn btn-success']) ?>
    </div>
    <div class="col text-center">
        <?= Html::a('Наличие лекарств(список)', ['balance-of-goods-list'], ['class' => 'btn btn-success']) ?>
    </div>
</div>
</p>




