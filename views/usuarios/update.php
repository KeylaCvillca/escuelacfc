<?php 
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;

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

    <?= $form->field($model, 'nombre_apellidos')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'fecha_nacimiento')->input('date') ?>
    <?= $form->field($model, 'celula')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'fecha_ingreso')->input('date') ?>
    <?= $form->field($model, 'fecha_graduacion')->input('date') ?>
    <?= $form->field($model, 'rol')->dropDownList(['admin' => 'Admin', 'maestra' => 'Maestra', 'alumna' => 'Alumna'], ['prompt' => 'Elige un rol']) ?>
    <?= $form->field($model, 'color')->dropDownList(
        ArrayHelper::map($niveles, 'color', 'color'),
        ['prompt' => 'Elige un nivel', 'id' => 'color-select']
    ) ?>

    <div id="telefonos">
        <div class="form-group telefono-grupo">
            <label for="telefono-0">Teléfono</label>
            <div class="input-group">
                <?= Html::dropDownList('AddUserForm[pais_telefonos][]', null, $paises, ['class' => 'form-control pais-telefono', 'data-index' => '0']) ?>
                <span class="input-group-text" id="prefijo-0"><?= $prefijos[$model->pais] ?? '' ?></span>
                <input type="text" name="AddUserForm[telefonos][]" class="form-control">
            </div>
        </div>
    </div>
    <button type="button" id="add-phone" class="btn btn-primary">Añadir Teléfono</button>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
$prefijosJson = json_encode($prefijos);
$script = <<< JS
var prefijos = $prefijosJson;

$('#add-phone').on('click', function () {
    var index = $('#telefonos .telefono-grupo').length;
    var phoneField = '<div class="form-group telefono-grupo">' +
                     '<label for="telefono-' + index + '">Teléfono</label>' +
                     '<div class="input-group">' +
                     '<select class="form-control pais-telefono" data-index="' + index + '" name="AddUserForm[pais_telefonos][]">' +
                     Object.keys(prefijos).map(function(key) {
                        return '<option value="' + key + '">' + key + '</option>';
                     }).join('') +
                     '</select>' +
                     '<span class="input-group-text" id="prefijo-' + index + '"></span>' +
                     '<input type="text" name="AddUserForm[telefonos][]" class="form-control">' +
                     '</div>' +
                     '</div>';
    $('#telefonos').append(phoneField);
    updatePrefijos(index);
});

$('#telefonos').on('change', '.pais-telefono', function () {
    var index = $(this).data('index');
    updatePrefijos(index);
});

function updatePrefijos(index) {
    var pais = $('.pais-telefono[data-index="' + index + '"]').val();
    var prefijo = prefijos[pais] || '';
    $('#prefijo-' + index).text(prefijo);
}

// Inicializar prefijos al cargar la página
updatePrefijos(0);

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
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form'); // Selecciona el formulario
    const colorSelect = document.getElementById('color-select'); // Selecciona el campo de color

    form.addEventListener('submit', function (event) {
        if (colorSelect.value === '') {
            // Si el campo de color no tiene un valor seleccionado, evita el envío del formulario
            event.preventDefault();
            alert('Por favor, elige un nivel antes de continuar.');
        }
    });
});
</script>
