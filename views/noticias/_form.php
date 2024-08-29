<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Noticias $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="noticias-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contenido')->textArea(['maxlength' => true,]) ?>

    <?= $form->field($model, 'publico')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
