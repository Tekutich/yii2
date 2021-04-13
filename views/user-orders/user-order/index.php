<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrdersDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Детали заказа';
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-details-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => 'Показаны {begin}-{end} из {totalCount} строк',
        'showFooter' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'tradeName',
                'format' => 'text',
                'value' => 'drugs.trade_name',
                'footer' => 'Итого',
            ],
            [
                'attribute' => 'form',
                'format' => 'text',
                'value' => 'drugsCharacteristics.form_of_issue',
            ],
            [
                'attribute' => 'dosage',
                'format' => 'text',
                'value' => 'drugsCharacteristics.dosage',
            ],
            [
                'attribute' => 'cost',
                'format' => 'text',
                'value' => 'drugsCharacteristics.cost',
            ],
            [
                'attribute' => 'count',
                'format' => 'text',
                'value' => 'count',
                'footer' => \app\models\OrderDetails::getTotalCount($dataProvider->models),
            ],
            [
                'attribute' => 'sum',
                'format' => 'text',
                'label' => 'Сумма',
                'value' => function ($model) {
                    $sum = $model->count * $model->drugsCharacteristics->cost;
                    return $sum;
                },
                'footer' => \app\models\OrderDetails::getTotalSum($dataProvider->models),
            ],
        ],
    ]); ?>
</div>
