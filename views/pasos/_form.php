<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Niveles;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\Pasos $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="Pasos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'cita_biblica')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textArea(['maxlength' => true]) ?>

    <?= $form->field($model, 'imagenFile')->label('Imagen: ')->fileInput() ?>

    <?= $form->field($model, 'color')->dropDownList(
        ArrayHelper::map(Niveles::find()->all(), 'color', 'color'),
        ['prompt' => 'Seleccionar nivel']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
