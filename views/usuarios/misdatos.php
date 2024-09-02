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
    
    <!-- Formulario para editar datos -->
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    <?= $form->field($model, 'fotoFile')->fileInput()->label("Subir foto") ?>
    <?= $form->field($model, 'nombre_apellidos')->textInput() ?>
    <?= $form->field($model, 'username')->textInput() ?>

    <?= $form->field($model, 'change_password')->checkbox() ?>

    <div id="password-fields" style="display: none;">
        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'id' => 'password', 'value' => 'Asdf.1234']) ?>
        <?= $form->field($model, 'confirm_password')->passwordInput(['maxlength' => true, 'id' => 'confirm_password', 'value' => 'Asdf.1234']) ?>

        <div id="password-message" style="color: red;"></div>
        <div id="confirm-password-message" style="color: red;"></div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php
    $this->registerJs("
        $('#adduserform-change_password').on('change', function() {
            if ($(this).is(':checked')) {
            $('#password').val('');
                $('#confirm_password').val('');
                $('#password-fields').show();
            } else {
                $('#password-fields').hide();
                $('#password').val('Asdf.1234');
                $('#confirm_password').val('Asdf.1234');
                $('#password-message').text('');
                $('#confirm-password-message').text('');
            }
        });

        $('#password, #confirm_password').on('input', function() {
            if ($('#adduserform-change_password').is(':checked')) {
                var password = $('#password').val();
                var confirmPassword = $('#confirm_password').val();
                var passwordMessage = '';
                var confirmPasswordMessage = '';

                // Nueva expresión regular con símbolos especiales
                var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[.,;_])[A-Za-z\d.,;_]{8,}$/;

                if (password.length > 0 && !passwordRegex.test(password)) {
                    passwordMessage = 'La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un dígito y un símbolo especial (.,;_).';
                    $('#password-message').css('color', 'red');
                } else if (password.length > 0) {
                    $('#password-message').css('color', 'green');
                    passwordMessage = 'Contraseña válida.';
                }

                if (password !== confirmPassword) {
                    confirmPasswordMessage = 'Las contraseñas no coinciden.';
                    $('#confirm-password-message').css('color', 'red');
                } else if (password.length > 0) {
                    $('#confirm-password-message').css('color', 'green');
                    confirmPasswordMessage = 'Las contraseñas coinciden.';
                }

                $('#password-message').text(passwordMessage);
                $('#confirm-password-message').text(confirmPasswordMessage);
            }
        });
    ");
    ?>
</div>
