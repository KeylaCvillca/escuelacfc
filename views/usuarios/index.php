<?php

use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $maestraProvider yii\data\ActiveDataProvider */
/* @var $alumnaProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Users';
?>

<div class="usuarios-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="usuarios-search">
        <?php $form = ActiveForm::begin([
            'method' => 'get',
        ]); ?>

        <?= $form->field($searchModel, 'nombre_apellidos')->textInput(['placeholder' => 'Search by name'])->label(false) ?>
        <?= $form->field($searchModel, 'telefono')->textInput(['placeholder' => 'Search by phone'])->label(false) ?>

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

    <h2>All Users</h2>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nombre_apellidos',
            'email',
            'rol',
            'celula',
            [
                'label' => 'Phone',
                'value' => function($model) {
                    return implode(', ', array_column($model->telefonos, 'telefono'));
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <h2>Users with Maestra Role</h2>
    <?= GridView::widget([
        'dataProvider' => $maestraProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nombre_apellidos',
            'email',
            'rol',
            'celula',
            [
                'label' => 'Phone',
                'value' => function($model) {
                    return implode(', ', array_column($model->telefonos, 'telefono'));
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <h2>Users with Alumna Role</h2>
    <?= GridView::widget([
        'dataProvider' => $alumnaProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nombre_apellidos',
            'email',
            'rol',
            'celula',
            [
                'label' => 'Phone',
                'value' => function($model) {
                    return implode(', ', array_column($model->telefonos, 'telefono'));
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
