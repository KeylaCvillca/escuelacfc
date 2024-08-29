<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Telefonos;

/** @var yii\web\View $this */
/** @var app\models\Telefonos $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="telefonos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'usuario')->dropDownList(
            Telefonos::getUserOptions(),
            ['prompt' => 'Elige un usuario']
        ) ?>

    <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
