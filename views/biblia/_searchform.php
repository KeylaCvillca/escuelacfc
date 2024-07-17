<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SearchForm */

?>

<div class="biblia-search">
    <?php $form = ActiveForm::begin([
        'action' => ['biblia/search'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'quote')->textInput(['maxlength' => true])->label('Buscar Versículo') ?>

    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
