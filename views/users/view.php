<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->email;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить данного пользователя?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'surname',
                'format' => 'text',
                'label' => 'Фамилия',
            ],
            [
                'attribute' => 'name',
                'format' => 'text',
                'label' => 'Имя',
            ],
            [
                'attribute' => 'patronymic',
                'format' => 'text',
                'label' => 'Отчество',
            ],
            'email:email',
            [
                'value' => function ($model) {
                    if ($model->role === 0) {
                        return "Пользователь";
                    } else {
                        return "Администратор";
                    }
                },

                'label' => 'Роль',
                'attribute' => 'role',
            ],
        ],
    ]) ?>

</div>
