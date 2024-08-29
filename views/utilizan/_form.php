<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Instrumentos;
use app\models\Pasos;

/* @var $this yii\web\View */
/* @var $model app\models\Utilizan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="utilizan-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'instrumento')->dropDownList(
        ArrayHelper::map(Instrumentos::find()->all(), 'id', 'nombre'),
        ['prompt' => 'Seleccionar Instrumento']
    ) ?>

    <?= $form->field($model, 'paso')->dropDownList(
        ArrayHelper::map(Pasos::find()->all(), 'id', 'nombre'),
        ['prompt' => 'Seleccionar Paso']
    ) ?>

    <?= $form->field($model, 'file')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
