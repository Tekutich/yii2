<?php

use app\models\User;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RegistrationForm */
/* @var $form yii\bootstrap4\ActiveForm */
$this->title = 'Регистрация';

?>
<div class="registration">




    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => [
            'class' => 'form-signin',
        ],

        'fieldConfig' => [

            // 'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\"><div class=\"is-invalid\"></div>{error}</div>",
            //  'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>
    <div class="text-center mb-4">
        <h1 class="h3 mb-3 font-weight-normal">Регистрация</h1>
        <p>Введите данные для регистрации:</p>
    </div>

    <?= $form->field($model, 'username',['template' => '{input}{label}{error}{hint}','options' => ['class' => 'form-label-group'],])->textInput(['autofocus' => true,'class'=>'form-control','placeholder'=>"Email",'id'=>"inputEmail"]) ?>
    <?= $form->field($model, 'password',['template' => '{input}{label}{error}{hint}','options' => ['class' => 'form-label-group'],])->passwordInput(['class'=>'form-control','placeholder'=>"Пароль"]) ?>
    <?= $form->field($model, 'surname',['template' => '{input}{label}{error}{hint}','options' => ['class' => 'form-label-group'],])->passwordInput(['class'=>'form-control','placeholder'=>"Фамилия"]) ?>
    <?= $form->field($model, 'name',['template' => '{input}{label}{error}{hint}','options' => ['class' => 'form-label-group'],])->passwordInput(['class'=>'form-control','placeholder'=>"Имя"]) ?>
    <?= $form->field($model, 'patronymic',['template' => '{input}{label}{error}{hint}','options' => ['class' => 'form-label-group'],])->passwordInput(['class'=>'form-control','placeholder'=>"Отчество"]) ?>





    <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary btn-registration']) ?>

    <?php ActiveForm::end(); ?>


</div><!-- registation -->

