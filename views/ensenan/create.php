<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Asignar Función';
?>

<div class="ensenan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="ensenan-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'maestra')->dropDownList(
            \yii\helpers\ArrayHelper::map($maestras, 'id', 'nombre_apellidos'),
            ['prompt' => 'Elige Maestra']
        ) ?>

        <?= $form->field($model, 'color')->dropDownList(
            \yii\helpers\ArrayHelper::map($niveles, 'color', 'color'),
            ['prompt' => 'Elige Color']
        ) ?>

        <?= $form->field($model, 'funcion')->dropDownList([
            'titular' => 'Titular',
            'auxiliar' => 'Auxiliar',
        ], ['prompt' => 'Elige Función']) ?>

        <div class="form-group">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
