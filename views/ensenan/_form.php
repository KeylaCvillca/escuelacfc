<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Ensenan $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ensenan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'maestra')->textInput() ?>

    <?= $form->field($model, 'color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'funcion')->textInput(['maxlength' => true])->prompt['Elige una función'] ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
