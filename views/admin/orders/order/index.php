<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrdersDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Детали заказа';
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['orders']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-details-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => 'Показаны {begin}-{end} из {totalCount} строк',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'form',
            'dosage',
            'cost',
            'count',

        ],
    ]); ?>


</div>
