<?php

use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Niveles;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $maestraProvider yii\data\ActiveDataProvider */
/* @var $alumnaProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
?>

<div class="usuarios-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="usuarios-search">
        <?php $form = ActiveForm::begin([
            'method' => 'get',
        ]); ?>
        <div class="d-flex justify-content-between">
            <h4 style="padding-right: 20px">Filtros:</h4>
            <?= $form->field($searchModel, 'nombre_apellidos')->textInput(['placeholder' => 'Nombre y Apellidos'])->label(false) ?>
            <?= $form->field($searchModel, 'rol')->dropDownList(
                ['admin' => 'Admin', 'maestra' => 'Maestra', 'alumna' => 'Alumna'],
                ['prompt' => 'Rol']
            )->label(false) ?>  
            <?= $form->field($searchModel, 'email')->textInput(['placeholder' => 'Email'])->label(false) ?>
            <?= $form->field($searchModel, 'color')->dropDownList(
                ArrayHelper::map(Niveles::find()->all(), 'color', 'color'),
                ['prompt' => 'Nivel']
            )->label(false) ?>
            <?= $form->field($searchModel, 'telefono')->textInput(['placeholder' => 'Teléfono'])->label(false) ?>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Todos', ['index'], ['class' => 'btn btn-secondary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'nombre_apellidos',
            'email',
            'rol',
            'color',
            'celula',
            [
                'label' => 'Teléfonos',
                'value' => function($model) {
                    return implode(', ', array_column($model->telefonos, 'telefono'));
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
        'summary' => ''
    ]); ?>
</div>
