<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\icons\Icon;
//use yii\bootstrap4\GridView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;

Icon::map($this);
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить пользователя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => 'Показаны {begin}-{end} из {totalCount} строк',

        'pager' => [
            'maxButtonCount' => 5,
            'options' => ['class' => 'pagination'],
            'nextPageCssClass'=>'page-link',
            'prevPageLabel' => 'Предыдущая',
            'nextPageLabel' => 'Следующая',
            'prevPageCssClass'=>'page-link',
            'pageCssClass' => 'page-link',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            //фамилия
            [
                'contentOptions' => ['class' => 'text-center'],
                'attribute' => 'surname',
                'format' => 'text',
                'label' => 'Фамилия',
            ],
            //имя
            [
                'contentOptions' => ['class' => 'text-center'],
                'attribute' => 'name',
                'format' => 'text',
                'label' => 'Имя',
            ],
            //отчество
            [
                'contentOptions' => ['class' => 'text-center'],
                'attribute' => 'patronymic',
                'format' => 'text',
                'label' => 'Отчество',
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'attribute' => 'email',
                'format' => 'email',
                'label' => 'Email',
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    if ($model->role===0){
                        return "Пользователь";
                    }else{
                        return "Администратор";
                    }
                },
                'format' => 'text',
                'label' => 'Роль',
            ],


            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['class' => 'text-center'],
                'header' => 'Действия',
                'headerOptions' => ['class'=>'text-center'],
                'template' => '<div class="btn-group" role="group" aria-label="Basic example">{view}{update}{delete}</div>',

                'buttons' => [

                    'view' => function ($url, $model) {
                        return Html::a(Icon::show('eye'), $url, [
                            'title' => 'View',
                            'class' => 'btn btn-primary'
                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a(Icon::show('edit'), $url, [
                            'title' => 'Update',
                            'class'=>'btn btn-warning',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a(Icon::show('trash'), $url, [
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
