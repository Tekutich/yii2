<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\LoginForm */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = 'Вход';
?>
<?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => [
        'class' => 'form-signin',
    ],
]); ?>
<div class="text-center mb-4">
    <h1 class="h3 mb-3 font-weight-normal">Вход</h1>
    <p>Введите данные для авторизации:</p>
</div>

<?= $form->field($model, 'username', ['template' => '{input}{label}{error}{hint}', 'options' => ['class' => 'form-label-group'],])->textInput(['autofocus' => true, 'class' => 'form-control', 'placeholder' => "Email", 'id' => "inputEmail"]) ?>

<div class="form-label-group">
    <?= $form->field($model, 'password', ['template' => '{input}{label}{error}{hint}', 'options' => ['class' => 'form-label-group'],])->passwordInput(['class' => 'form-control', 'placeholder' => "Пароль"]) ?>
</div>

<div class="checkbox mb-3">
    <label>
        <?= $form->field($model, 'rememberMe')->checkbox([]) ?>
    </label>
</div>
<?= Html::submitButton('Войти', ['class' => 'btn btn-lg btn-primary btn-block btn-enter', 'name' => 'login-button']) ?>
<?= Html::a('Регистрация', 'registration', ['class' => 'btn btn-primary button-registration']) ?>
<?php ActiveForm::end(); ?>
