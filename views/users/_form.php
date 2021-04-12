<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
/** @var  $Create */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'surname')->textInput()->label('Фамилия') ?>
    <?= $form->field($model, 'name')->textInput()->label('Имя') ?>
    <?= $form->field($model, 'patronymic')->textInput()->label('Отчество') ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <? if ($model->isNewRecord) { ?>
        <?= $form->field($model, 'password')->textInput()->label('Пароль') ?>
    <? } else { ?>
        <?= $form->field($model, 'new_password')->textInput()->label('Новый пароль') ?>
    <? } ?>
    <?= $form->field($model, 'role')->dropDownList(
        [
            '0' => 'Пользователь',
            '1' => 'Администратор'
        ],
        [
            'disabled' => yii::$app->user->id === $model->id ? true : false,
        ]);
    ?>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
