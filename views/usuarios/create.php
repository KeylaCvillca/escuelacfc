 <?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Niveles;

/* @var $this yii\web\View */
/* @var $model app\models\AddUserForm */
/* @var $form yii\widgets\ActiveForm */
$nivelesList = ArrayHelper::map($niveles, 'id', 'color');
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
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'id' => 'password']) ?>
    <?= $form->field($model, 'confirm_password')->passwordInput(['maxlength' => true, 'id' => 'confirm_password']) ?>
    <?= $form->field($model, 'fecha_nacimiento')->input('date') ?>
    <?= $form->field($model, 'celula')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'fecha_ingreso')->input('date') ?>
    <?= $form->field($model, 'fecha_graduacion')->input('date') ?>
    <?= $form->field($model, 'rol')->dropDownList(['admin' => 'Admin', 'maestra' => 'Maestra', 'alumna' => 'Alumna'], ['prompt' => 'Elige un rol']) ?>
    <?= $form->field($model, 'color')->dropDownList(
            \yii\helpers\ArrayHelper::map($niveles, 'color', 'color'),
            ['prompt' => 'Elige un nivel']
    ) ?> 
    <?= $form->field($model, 'pais')->dropDownList($paises, ['prompt' => 'Seleccione su país', 'value' => $model->pais]) ?>

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
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    const passwordMessage = document.createElement('div');
    const confirmPasswordMessage = document.createElement('div');

    // Añadir los mensajes de validación después de los campos de contraseña
    password.parentNode.appendChild(passwordMessage);
    confirmPassword.parentNode.appendChild(confirmPasswordMessage);

    function validatePassword() {
        const passwordValue = password.value;

        // Expresión regular para validar la contraseña
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

        if (passwordRegex.test(passwordValue)) {
            passwordMessage.textContent = 'La contraseña es válida.';
            passwordMessage.style.color = 'green';
        } else {
            passwordMessage.textContent = 'La contraseña debe tener al menos 8 caracteres, incluyendo una mayúscula, una minúscula, un dígito y un símbolo.';
            passwordMessage.style.color = 'red';
        }
    }

    function validateConfirmPassword() {
        const passwordValue = password.value;
        const confirmPasswordValue = confirmPassword.value;

        if (passwordValue === confirmPasswordValue) {
            confirmPasswordMessage.textContent = 'Las contraseñas coinciden.';
            confirmPasswordMessage.style.color = 'green';
        } else {
            confirmPasswordMessage.textContent = 'Las contraseñas no coinciden.';
            confirmPasswordMessage.style.color = 'red';
        }
    }

    password.addEventListener('input', validatePassword);
    confirmPassword.addEventListener('input', validateConfirmPassword);
});
</script>
