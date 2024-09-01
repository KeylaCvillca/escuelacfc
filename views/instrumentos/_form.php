<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Instrumento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="instrumento-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'significado')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'cita_biblica')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'imagenFile')->fileInput() ?>
    
    

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
