<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Entrar';
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Introduzca usuario o correo electrónico y contraseña para entrar:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-2 col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'col-lg-4 form-control'],
            'errorOptions' => ['class' => 'col-lg-6 invalid-feedback'],
        ],
    ]); ?>

        <?= $form->field($model, 'usernameOrEmail')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
           'class' => 'custom-control-input',
            'labelOptions' => ['class' => 'custom-control-label'],
            'template' => "<div class=\"offset-lg-2 col-lg-4 custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-6\">{error}</div>",
        ]) ?>

        <div class="form-group">
            <div class="offset-lg-2 col-lg-10">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>
