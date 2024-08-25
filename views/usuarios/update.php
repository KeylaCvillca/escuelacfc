<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AddUserForm */

$this->title = 'Actualizar';
?>

<div class="usuarios-misdatos">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?= $form->field($model, 'nombre_apellidos')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'fecha_nacimiento')->input('date') ?>
    <?= $form->field($model, 'celula')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'fecha_ingreso')->input('date') ?>
    <?= $form->field($model, 'fecha_graduacion')->input('date') ?>
    <?= $form->field($model, 'color')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'telefonos[]')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fotoFile')->fileInput() ?>
    
    <?php if ($model->foto): ?>
        <div>
            <p>Current photo:</p>
            <img src="<?= Yii::getAlias('@web') ?>/imagenes/usuarios/<?= Html::encode($model->foto) ?>" alt="Profile photo" style="max-width: 150px; max-height: 150px;">
        </div>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
