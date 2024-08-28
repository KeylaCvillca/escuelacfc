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
        'options' => ['class' => 'row g-3 d-flex flex-wrap justify-content-around align-items-center'],
    ]); ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'color')->dropDownList(
        \yii\helpers\ArrayHelper::map(\app\models\Niveles::find()->all(), 'color', 'descripcion'),
        ['prompt' => 'Todos']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
