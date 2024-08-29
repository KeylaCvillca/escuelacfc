<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use app\models\Telefonos;

/** @var yii\web\View $this */
/** @var app\models\Telefonos $model */

$this->title = $model->getUsuarioAttribute('nombre_apellidos');
$this->params['breadcrumbs'][] = ['label' => 'Telefonos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="telefonos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'User Name',
                'value' => function ($model) {
                    return $model->getUsuarioAttribute('nombre_apellidos');
                },
            ],
            [
                'label' => 'Username',
                'value' => function ($model) {
                    return  $model->getUsuarioAttribute('username');
                },
            ],
            [
                'label' => 'Email',
                'value' => function ($model) {
                    return  $model->getUsuarioAttribute('email');
                },
            ],
        ],
    ]) ?>

    <h2>Teléfonos asociados</h2>

    <?= GridView::widget([
        'dataProvider' => new \yii\data\ArrayDataProvider([
            'allModels' => $model->getUserPhones($model->usuario),
            'pagination' => false,
        ]),
        'columns' => [
            'id',
            'telefono',
        ],
        'summary' => ''
    ]) ?>

</div>
