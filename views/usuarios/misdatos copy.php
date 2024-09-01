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
                'label' => 'Nivel'],
            [   
                'attribute' => 'fecha_nacimiento',
                'value' => function($model) {
                    return $model->getFechaFormateada('fecha_nacimiento');
                }
            ],
            [   
                'attribute' => 'fecha_graduacion',
                'value' => function($model) {
                    return $model->getFechaFormateada('fecha_nacimiento');
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

    <div id="telefonos">
        <div class="form-group telefono-grupo">
            <label for="telefono-0">Teléfono</label>
            <div class="input-group d-flex">
                <?= Html::dropDownList('AddUserForm[pais_telefonos][]', null, $paises, ['class' => 'form-control pais-telefono col-sm-3', 'data-index' => '0']) ?>
                <span class="input-group-text col-sm-1" id="prefijo-0"><?= $prefijos[$model->pais] ?? '' ?></span>
                <input type="text" name="AddUserForm[telefonos][]" class="form-control col-sm-8">
            </div>
        </div>
    </div>
    <button type="button" id="add-phone" class="btn btn-primary">Añadir Teléfono</button>

    
    
    

    <!-- Checkbox para activar el cambio de contraseña -->
    <?= $form->field($model, 'change_password')->checkbox(['id' => 'change-password-checkbox', 'value' => 1])?>
    
    <div id="password-fields" style="display: none;">
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

<?php
$prefijosJson = json_encode($prefijos);
$script = <<< JS
$(document).ready(function() {
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

    $('#change-password-checkbox').on('change', function () {
        $('#password-fields').toggle(this.checked);
    });

    // Validación de contraseñas
    function validatePassword() {
        const password = $('#password').val();
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
        const message = $('#password-message');
        
        if (passwordRegex.test(password)) {
            message.text('La contraseña es válida.').css('color', 'green');
        } else {
            message.text('La contraseña debe tener al menos 8 caracteres, incluyendo una mayúscula, una minúscula, un dígito y un símbolo.').css('color', 'red');
        }
    }

    function validateConfirmPassword() {
        const password = $('#password').val();
        const confirmPassword = $('#confirm_password').val();
        const message = $('#confirm-password-message');
        
        if (password === confirmPassword) {
            message.text('Las contraseñas coinciden.').css('color', 'green');
        } else {
            message.text('Las contraseñas no coinciden.').css('color', 'red');
        }
    }

    $('#password').on('input', validatePassword);
    $('#confirm_password').on('input', validateConfirmPassword);


    // Alternar visibilidad de contraseñas
    $('#toggle-password').on('click', function () {
        const passwordField = $('#password');
        const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
        passwordField.attr('type', type);
        $(this).text(type === 'password' ? 'Mostrar Contraseña' : 'Ocultar Contraseña');
    });

    $('#toggle-confirm-password').on('click', function () {
        const confirmPasswordField = $('#confirm_password');
        const type = confirmPasswordField.attr('type') === 'password' ? 'text' : 'password';
        confirmPasswordField.attr('type', type);
        $(this).text(type === 'password' ? 'Mostrar Confirmar Contraseña' : 'Ocultar Confirmar Contraseña');
    });
});
JS;
$this->registerJs($script);
?>
  