<?php

use app\models\DrugsCharacteristics;
use app\models\DrugsDrugsCharacteristicsLink;
use kartik\date\DatePicker;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\icons\Icon;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params[ 'breadcrumbs' ][] = $this->title;
Icon::map($this);
?>
<div class="orders-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
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
            'userSurname',
            'userName',
            'userPatronymic',
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
            //имя

                [
                    'attribute' => 'cost',
                    'format' => 'html',
                    'label' => 'Сумма',
                    'value' => function ($model) {
                        $phones = '';

                       echo "<pre>";
                      $kek=$model;
                       print_r($kek);
                       //print_r($model->drugsDrugsCharacteristicsLink);
                        echo "</pre>";
                        foreach ($model->orderDetails as $value) {
                           $drugLink = DrugsDrugsCharacteristicsLink::findAll($value['drugs_drugs_characteristics_link_id']);
                            foreach ($drugLink as $value1)  {
                                $drug = \app\models\DrugsCharacteristics::findOne($value1['drugs_characteristics_id']);
                                echo "<pre>";
                           // print_r($drug);
                               $cost+=$drug->cost;
                              echo "</pre>";
                          }
                        }

                       // $kek222+=$model->drugsDrugsCharacteristicsLink->drugsCharacteristics->cost;
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
                        return Html::a(Icon::show('eye'), ["/admin/order", 'id' => $model->id], [
                            'title' => 'View',
                            'class' => 'btn btn-primary'
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a(Icon::show('trash'), ["/admin/delete-order", 'id' => $model->id], [
                            'title' => 'Delete',
                            'class'=>'btn btn-danger',
                            'data' => [
                                'method' => 'post',
                                'confirm' => 'Удалить данную строку?',
                            ]
                        ]);
                    },

                ],
            ],
        ],
    ]); ?>


</div>
