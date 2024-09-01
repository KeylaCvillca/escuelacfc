<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\UploadForm */

$this->title = 'Cargar Usuarios desde Excel';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="upload-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'file')->fileInput()->label('') ?>

    <div class="form-group">
        <?= Html::submitButton('Cargar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<div class="instructions">
    <h2>Instrucciones para Subir Usuarios desde un Archivo Excel</h2>
    <p>
        Para cargar usuarios desde un archivo Excel, sigue estos pasos:
    </p>
    <ol>
        <li>Prepara un archivo Excel con la información de los usuarios que deseas subir. El archivo debe tener las siguientes columnas:
            <ul>
                <li><strong>nombre_apellidos:</strong> Nombre completo del usuario.</li>
                <li><strong>rol:</strong> El rol del usuario (maestra, alumna, admin).</li>
                <li><strong>fecha_nacimiento:</strong> Fecha de nacimiento del usuario (formato: yyyy-mm-dd).</li>
                <li><strong>celula:</strong> Documento de identificación del usuario.</li>
                <li><strong>fecha_ingreso:</strong> Fecha de ingreso (formato: yyyy-mm-dd).</li>
                <li><strong>fecha_graduacion:</strong> Fecha de graduación, si aplica (formato: yyyy-mm-dd).</li>
                <li><strong>email:</strong> Correo electrónico del usuario.</li>
                <li><strong>password:</strong> Contraseña del usuario.</li>
                <li><strong>Teléfonos</strong> Teléfonos del usuario en formato [Código país]-[Número], separados por comas.</li>
                <li><strong>niveles:</strong> Nivel en el que enseña el usuario (solo para maestras), separados por comas.</li>
                <li><strong>funciones:</strong> Funciones que desempeña el usuario en cada nivel (titular o auxiliar, solo para maestras), separados por comas</li>
            </ul>
        </li>
        <li>Asegúrate de que los datos estén correctamente formateados. Las fechas deben estar en el formato <strong>yyyy-mm-dd</strong>.</li>
        <li>Guarda el archivo en formato Excel (.xlsx).</li>
        <li>Haz clic en el botón <strong>Seleccionar archivo</strong> y elige tu archivo Excel.</li>
        <li>Haz clic en el botón <strong>Cargar</strong> para subir el archivo y procesar los usuarios.</li>
    </ol>
</div>
<div>
<h2>Ejemplo de formato del archivo Excel:</h2>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['attribute' => 'A: nombre_apellidos'],
            ['attribute' => 'B: rol'],
            ['attribute' => 'C: fecha_nacimiento'],
            ['attribute' => 'D: celula'],
            ['attribute' => 'E: fecha_ingreso'],
            ['attribute' => 'F: fecha_graduacion'],
            ['attribute' => 'G: email'],
            ['attribute' => 'H: color'],
            ['attribute' => 'I: password'],
            ['attribute' => 'J: telefonos'],
            ['attribute' => 'K: niveles'],
            ['attribute' => 'L: funciones'],
        ],
        'options' => [
            'style' => 'overflow-x: scroll'
        ],
        'summary' => ''
    ]) ?>
</div>
