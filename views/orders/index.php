<?php

use kartik\date\DatePicker;
use yii\grid\GridView;
use yii\helpers\Html;
use kartik\icons\Icon;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
Icon::map($this);
?>
<div class="orders-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => 'Показаны {begin}-{end} из {totalCount} строк',
        'pager' => [
            'maxButtonCount' => 5,
            'options' => ['class' => 'pagination'],
            'nextPageCssClass' => 'page-link',
            'prevPageLabel' => 'Предыдущая',
            'nextPageLabel' => 'Следующая',
            'prevPageCssClass' => 'page-link',
            'pageCssClass' => 'page-link',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'userSur',
                'format' => 'text',
                'label' => 'Фамилия',
                'value' => 'user.surname',
            ],
            [
                'attribute' => 'userName',
                'format' => 'text',
                'label' => 'Имя',
                'value' => 'user.name',
            ],
            [
                'attribute' => 'userPatronymic',
                'format' => 'text',
                'label' => 'Отчество',
                'value' => 'user.patronymic',
            ],
            //дата
            [
                'attribute' => 'date',
                'format' => ['date', 'php:d.m.Y'],
                'label' => 'Дата',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date',

                    'pluginOptions' => [
                        'format' => 'dd.mm.yyyy',
                        'autoclose' => true,
                    ]
                ])
            ],
            //товары
            [
                'attribute' => 'products',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'format' => 'html',
                'label' => 'Товары',
                'value' => function ($model) {
                    $name = '';
                    foreach ($model->orderDetails as $key => $value) {
                        $name .= $model->orderDetails[$key]->drugs->trade_name . ", ";
                    }
                    return substr($name, 0, -2);
                },
            ],
            //сумма
            [
                'attribute' => 'cost',
                'contentOptions' => ['class' => 'text-center'],
                'format' => 'html',
                'label' => 'Сумма',
                'value' => function ($model) {
                    foreach ($model->orderDetails as $key => $value) {
                        $cost += $model->orderDetails[$key]->drugsCharacteristics->cost * $model->orderDetails[$key]->count;
                    }
                    return $cost;
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Действия',
                'contentOptions' => ['class' => 'text-center'],
                'headerOptions' => ['width' => '150px'],
                'template' => '<div class="btn-group" role="group" aria-label="Basic example">{view}{delete}</div>',

                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a(Icon::show('eye'), ["order", 'id' => $model->id], [
                            'title' => 'View',
                            'class' => 'btn btn-primary'
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a(Icon::show('trash'), ["/admin/delete-order", 'id' => $model->id], [
                            'title' => 'Delete',
                            'class' => 'btn btn-danger',
                            'data' => [
                                'method' => 'post',
                                'confirm' => 'Вы действительно хотите удалить данный заказ?',
                            ]
                        ]);
                    },

                ],
            ],
        ],
    ]); ?>
</div>
