<?php

use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

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
        <div class="d-flex">
            <h2>Filtros:</h2>
            <?= $form->field($searchModel, 'nombre_apellidos')->textInput(['placeholder' => 'Nombre y Apellidos'])->label(false) ?>
            <?= $form->field($searchModel, 'rol')->textInput(['placeholder' => 'Rol'])->label(false) ?>
            <?= $form->field($searchModel, 'email')->textInput(['placeholder' => 'Email'])->label(false) ?>
            <?= $form->field($searchModel, 'color')->textInput(['placeholder' => 'Color'])->label(false) ?>
            <?= $form->field($searchModel, 'telefono')->textInput(['placeholder' => 'Teléfono'])->label(false) ?>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Reset', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    <div class="add_usuarios">
        <p><?= Html::a('Crear Usuario', ['usuarios/create'],['class' => 'btn btn-success'])?></p>
        <p><?= Html::a('Añadir usuarios desde excel', ['usuarios/upload'],['class' => 'btn btn-success'])?></p>
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
                'label' => 'Phone',
                'value' => function($model) {
                    return implode(', ', array_column($model->telefonos, 'telefono'));
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
        'summary' => ''
    ]); ?>
</div>
