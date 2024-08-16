<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AddUserForm */

$this->title = 'Mis Datos';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="usuarios-misdatos">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre_apellidos')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fecha_nacimiento')->input('date') ?>

    <?= $form->field($model, 'celula')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fecha_ingreso')->input('date') ?>

    <?= $form->field($model, 'fecha_graduacion')->input('date') ?>

    <?= $form->field($model, 'foto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telefonos[]')->textInput(['maxlength' => true])->label('Teléfonos (Separar por comas si son múltiples)') ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar Cambios', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
