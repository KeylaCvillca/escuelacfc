<?php

use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Niveles;

/* @var $this yii\web\View */
/* @var $model app\models\AddUserForm */

$this->title = 'Mis datos';

$paises = [
    'US' => 'Estados Unidos',
    'CA' => 'Canadá',
    'MX' => 'México',
    'ES' => 'España',
    // Añade más países según sea necesario
];

$prefijos = [
    'US' => '+1',
    'CA' => '+1',
    'MX' => '+52',
    'ES' => '+34',
    // Añade más prefijos según sea necesario
];
?>

<div class="usuarios-misdatos">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="d-flex">
    <?php if ($model->foto): ?>
        <div>
            <img src="<?= Yii::getAlias('@web') ?>/imagenes/usuarios/<?= Html::encode($model->foto) ?>" alt="Foto de perfil"
                 style="max-width: 230px; max-height: 230px; border-radius:10px;padding-right: 5px; overflow: hidden">
        </div>
    <?php endif; ?>
        <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nombre_apellidos',
            'email:email',
            [   
                'attribute' => 'fecha_nacimiento',
                'value' => function($model) {
                    return $model->getFechaFormateada('fecha_nacimiento');
                }
            ],
            [
                'attribute' => 'color',
                'label' => 'Nivel',
            ],
            [   
                'attribute' => 'fecha_inscripcion',
                'value' => function($model) {
                    return $model->getFechaFormateada('fecha_inscripcion');
                }
            ],
            [   
                'attribute' => 'fecha_graduacion',
                'value' => function($model) {
                    return $model->getFechaFormateada('fecha_graduacion');
                }
            ],
        ],
    ]) ?>
        
    </div>
    
    <!-- DetailView para mostrar datos no modificables -->
    

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    <?= $form->field($model, 'fotoFile')->fileInput()->label("Subir foto") ?>
    <?= $form->field($model, 'nombre_apellidos')->textInput() ?>
    <?= $form->field($model, 'username')->textInput() ?>

    <?= $form->field($model, 'change_password')->checkbox()?>
    
    <div id="password-fields">
        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'id' => 'password']) ?>
        <?= $form->field($model, 'confirm_password')->passwordInput(['maxlength' => true, 'id' => 'confirm_password']) ?>

        <div id="password-message"></div>
        <div id="confirm-password-message"></div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

