<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PasosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pasos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class' => 'row  d-flex flex-wrap justify-content-around'],
    ]); ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'color')->dropDownList(
        \yii\helpers\ArrayHelper::map(\app\models\Niveles::find()->all(), 'color', 'color'),
        ['prompt' => 'Todos']
    ) ?>

    <div class="form-group d-flex flex-column justify-content-center" style="margin-top: 1.9vh;">
        <div class="d-flex justify-content-center">
            <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary','style'=>'margin-right: 2vw']) ?>
            <?= Html::resetButton('Todos', ['class' => 'btn btn-warning']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
