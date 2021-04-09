<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\LoginForm */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

//use yii\bootstrap\ActiveForm;

$this->title = 'Вход';
?>

<!--    <h1>--><?//= Html::encode($this->title) ?><!--</h1>-->
    <? //echo Yii::$app->getSecurity()->generatePasswordHash('123');?>


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
        <h1 class="h3 mb-3 font-weight-normal">Вход</h1>
        <p>Введите данные для авторизации:</p>
    </div>

        <?= $form->field($model, 'username',['template' => '{input}{label}{error}{hint}','options' => ['class' => 'form-label-group'],])->textInput(['autofocus' => true,'class'=>'form-control','placeholder'=>"Email",'id'=>"inputEmail"]) ?>

    <div class="form-label-group">
        <?= $form->field($model, 'password',['template' => '{input}{label}{error}{hint}','options' => ['class' => 'form-label-group'],])->passwordInput(['class'=>'form-control','placeholder'=>"Пароль"]) ?>
    </div>

    <div class="checkbox mb-3">
        <label>
            <?= $form->field($model, 'rememberMe')->checkbox([]) ?>
        </label>
    </div>

    <?= Html::submitButton('Войти', ['class' => 'btn btn-lg btn-primary btn-block btn-enter', 'name' => 'login-button']) ?>
    <?= Html::a('Регистрация', '/index.php?r=site%2Fregistration', ['class' => 'btn btn-primary button-registration']) ?>
<!--    <div class="form-group">-->
<!--        <div class="col-lg-offset-1 col-lg-11">-->
<!--            --><?//= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
<!--        </div>-->
<!--        <div class="col-lg-offset-1 col-lg-11">-->
<!--            --><?//= Html::a('Регистрация', '/index.php?r=site%2Fregistration', ['class' => 'btn btn-primary button-registration']) ?>
<!--        </div>-->
<!--    </div>-->

    <?php ActiveForm::end(); ?>
