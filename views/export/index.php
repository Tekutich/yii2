<?php
/* @var $this yii\web\View */
/* @var $model */
use yii\bootstrap4\Html;
$this->title = 'Отчёты';
?>
<h1 class="text-center">Выберите отчёт</h1>

<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th class="export-th">#</th>
        <th>Тип отчёта</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>1</td>
        <td><?= Html::a('Заказы', ['orders']) ?></td>
    </tr>
    <tr>
        <td>2</td>
        <td><?= Html::a('Наличие лекарств(таблица)', ['balance-of-goods-table']) ?></td>
    </tr>
    <tr>
        <td>3</td>
        <td><?= Html::a('Наличие лекарств(список)', ['balance-of-goods-list']) ?></td>
    </tr>
    </tbody>
</table>




