<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\Usuarios $model */

$this->title = $model->nombre_apellidos;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="usuarios-view">

    <h1>Usuario: <?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nombre_apellidos',
            [ 
                'attribute' =>'foto',
                'format' => 'html',
                'value' => function($model) {
                    return Html::img('@web/imagenes/usuarios/' . $model->foto,['alt' => 'Foto del usuario', 'style' => [
                        'width' => '50px'
                    ]]);
                }
            ],
            'color',
            'email:email',
            'username',
            'celula',
            'rol',
            'fecha_nacimiento',
            'fecha_ingreso',
            'fecha_graduacion',
        ],
    ]) ?>
    <h2>Teléfonos</h2>
    <?= GridView::widget([
        'dataProvider' => new \yii\data\ActiveDataProvider([
            'query' => $model->getTelefonos(),
        ]),
        'columns' => [
            'telefono',
        ],
    ]) ?>

    <!-- GridView para los niveles que enseña si el rol es "maestra" -->
    <?php if ($model->rol === 'maestra'): ?>
        <h2>Niveles que enseña</h2>
        <?= GridView::widget([
            'dataProvider' => new \yii\data\ActiveDataProvider([
                'query' => $model->getEnsenans(),
            ]),
            'columns' => [
                'color',
                'funcion',
                // otras columnas del modelo Ensenanza si las hay
            ],
        ]) ?>
    <?php endif; ?>
    

</div>
