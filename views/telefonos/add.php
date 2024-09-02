<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Telefonos */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Añadir Teléfono';
?>

<div class="telefono-add">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="telefono-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'telefono')->textInput(['maxlength' => true, 'placeholder' => 'Introduce tu número de teléfono']) ?>

        <div class="form-group">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
