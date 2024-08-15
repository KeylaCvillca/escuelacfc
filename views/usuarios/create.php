 <?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AddUserForm */
/* @var $form yii\widgets\ActiveForm */

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

<div class="user-create">
    <h1>Crear Usuario</h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre_apellidos')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'rol')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'fecha_nacimiento')->input('date') ?>
    <?= $form->field($model, 'celula')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'fecha_ingreso')->input('date') ?>
    <?= $form->field($model, 'fecha_graduacion')->input('date') ?>
    <?= $form->field($model, 'foto')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'pais')->dropDownList($paises, ['prompt' => 'Seleccione su país', 'value' => $model->pais]) ?>

    <div id="telefonos">
        <div class="form-group">
            <label for="telefono-0">Teléfono</label>
            <div class="input-group">
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
JS;
$this->registerJs($script);
?>
