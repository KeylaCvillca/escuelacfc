<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Utilizan $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="utilizan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'instrumento')->textInput() ?>

    <?= $form->field($model, 'paso')->textInput() ?>

    <?= $form->field($model, 'video')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
