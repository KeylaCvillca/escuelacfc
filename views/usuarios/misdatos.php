<?php

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

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <p>Nombre y Apellidos: <?= $model->nombre_apellidos ?></p>
    <p>Email: <?= $model->email ?></p>
    <?= $form->field($model, 'fecha_nacimiento')->input('date') ?>
    <?= $form->field($model, 'celula')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'fecha_ingreso')->input('date') ?>
    <?= $form->field($model, 'fecha_graduacion')->input('date') ?>
    <?= $form->field($model, 'color')->dropDownList(
        ArrayHelper::map(Niveles::find()->all(), 'color', 'color'),
        ['prompt' => 'Selecciona un color']
    )?>

    <div class="telefonos-wrapper">
        <label>Teléfonos:</label>
        <button type="button" id="add-phone" class="btn btn-success">Añadir Teléfono</button>

        <?php foreach ($model->telefonos as $index => $telefono): ?>
            <div class="phone-group">
                <?= Html::textInput("AddUserForm[telefonos][$index]", $telefono, ['class' => 'form-control']) ?>
                <button type="button" class="remove-phone btn btn-danger">Eliminar</button>
            </div>
        <?php endforeach; ?>
    </div>

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

<?php
$prefijosJson = json_encode($prefijos);
$script = <<< JS
var prefijos = $prefijosJson;

$('#add-phone').on('click', function () {
    var index = $('#telefonos .form-group').length;
    var phoneField = '<div class="form-group">' +
                     '<label for="telefono-' + index + '">Teléfono</label>' +
                     '<div class="input-group">' +
                     '<span class="input-group-text" id="prefijo-' + index + '"></span>' +
                     '<input type="text" name="AddUserForm[telefonos][]" class="form-control">' +
                     '</div>' +
                     '</div>';
    $('#telefonos').append(phoneField);
    updatePrefijos();
});

$('#adduserform-pais').on('change', function () {
    updatePrefijos();
});

function updatePrefijos() {
    var pais = $('#adduserform-pais').val();
    var prefijo = prefijos[pais] || '';
    $('#telefonos .input-group-text').text(prefijo);
}

updatePrefijos();
        
        $('#adduserform-rol').change(function() {
    if ($(this).val() === 'maestra') {
        $('#maestra-fields').show();
    } else {
        $('#maestra-fields').hide();
    }
}).trigger('change');
JS;
$this->registerJs($script);
?>
