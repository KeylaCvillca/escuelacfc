<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Telefonos;

/** @var yii\web\View $this */
/** @var app\models\Telefonos $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="telefonos-form">

    <?php $form = ActiveForm::begin(['id' => 'telefonos-form']); ?>

    <?= $form->field($model, 'usuario')->dropDownList(
            Telefonos::getUserOptions(),
            ['prompt' => 'Elige un usuario']
        ) ?>


    <?= $form->field($model, 'telefono', [])->textInput(['maxlength' => true, 'id' => 'telefono-0','required' => true]) ?>

    </div>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
