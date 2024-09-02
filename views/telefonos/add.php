<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Telefonos */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Añadir Teléfonos';

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

<div class="telefono-add">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="telefono-form">

        <?php $form = ActiveForm::begin(); ?>

        <div id="telefono-container">
            <div class="input-group d-flex telefono-group">
                <?= Html::dropDownList('paises[]', null, $paises, ['class' => 'form-control pais-telefono col-sm-3', 'data-index' => '0']) ?>
                <span class="input-group-text col-sm-1" id="prefijo-0"><?= $prefijos['US'] ?? '' ?></span>
                <?= Html::textInput('telefonos[]', '', ['maxlength' => true, 'class' => 'form-control col-sm-8']) ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::button('Añadir Teléfono', ['class' => 'btn btn-primary', 'id' => 'add-phone']) ?>
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>

<?php
$prefijosJson = json_encode($prefijos);
$script = <<< JS
var prefijos = $prefijosJson;

$('#add-phone').on('click', function () {
    var index = $('#telefono-container .telefono-group').length;
    var phoneField = '<div class="input-group d-flex telefono-group">' +
                     '<select class="form-control pais-telefono col-sm-3" data-index="' + index + '" name="paises[]">' +
                     Object.keys(prefijos).map(function(key) {
                        return '<option value="' + key + '">' + key + '</option>';
                     }).join('') +
                     '</select>' +
                     '<span class="input-group-text col-sm-1" id="prefijo-' + index + '"></span>' +
                     '<input type="text" name="telefonos[]" class="form-control col-sm-8">' +
                     '</div>';
    $('#telefono-container').append(phoneField);
    updatePrefijos(index);
});

$('#telefono-container').on('change', '.pais-telefono', function () {
    var index = $(this).data('index');
    updatePrefijos(index);
});

function updatePrefijos(index) {
    var pais = $('.pais-telefono[data-index="' + index + '"]').val();
    var prefijo = prefijos[pais] || '';
    $('#prefijo-' + index).text(prefijo);
}

// Initialize the prefix for the first phone input
updatePrefijos(0);
JS;
$this->registerJs($script);
?>
