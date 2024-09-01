<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Telefonos;

/** @var yii\web\View $this */
/** @var app\models\Telefonos $model */
/** @var yii\widgets\ActiveForm $form */

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

<div class="telefonos-form">

    <?php $form = ActiveForm::begin(['id' => 'telefonos-form']); ?>

    <?= $form->field($model, 'usuario')->dropDownList(
            Telefonos::getUserOptions(),
            ['prompt' => 'Elige un usuario']
        ) ?>

    <div class="form-group telefono-grupo">
        <label for="telefono-0">Teléfono</label>
        <div class="input-group">
            <?= Html::dropDownList('pais_telefono', null, $paises, [
                'class' => 'form-control pais-telefono', 
                'data-index' => '0',
                'prompt' => 'Selecciona un país',
            ]) ?>
            <span class="input-group-text" id="prefijo-0"><?= $prefijos['US'] ?? '' ?></span>
            <?= $form->field($model, 'telefono', [
                'template' => '{input}',
                'options' => ['class' => 'form-control'],
            ])->textInput(['maxlength' => true, 'id' => 'telefono-0']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$prefijosJson = json_encode($prefijos);
$script = <<< JS
var prefijos = $prefijosJson;

$('.pais-telefono').on('change', function () {
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
JS;
$this->registerJs($script);
?>
