<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Niveles;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\Pasos $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pasos-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'cita_biblica')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'descripcion')->textarea(['maxlength' => true]) ?>
    <?= $form->field($model, 'imagenFile')->fileInput() ?>
    <?= $form->field($model, 'color')->dropDownList(
        ArrayHelper::map(Niveles::find()->all(), 'color', 'color'),
        ['prompt' => 'Seleccionar nivel']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
