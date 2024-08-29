<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\controllers\BibliaController;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\Instrumentos $model */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Instrumentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="Instrumentos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'significado',
            'cita_biblica',
            [
                'attribute' => 'texto',
                'value' => function ($model) {
                    $textoCita = BibliaController::getText($model->cita_biblica);
                    return Html::encode($textoCita);
                }, 
            ],
        ],
    ]) ?>
    <img src="<?= Yii::getAlias('@web') . '/imagenes/instrumentos/' . strtolower($model->nombre) . '.jpg' ?>" alt="<?= Html::encode($model->nombre) ?>" class="img-fluid">
    
    <h2>Pasos relacionados</h2>
    <?= GridView::widget([
            'dataProvider' => $pasos,
            'columns' => [
                'nombre',
                'color',
                'cita_biblica',            
                [
                    'class' => 'yii\grid\ActionColumn',
                    'urlCreator' => function ($action, $model, $key, $index) {
                        return ['pasos/' . $action, 'id' => $model->id];
                    },
                ],
            ],
            'summary' => ''
    ]);?>

</div>
