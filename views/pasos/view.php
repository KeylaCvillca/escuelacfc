<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\controllers\BibliaController;

/** @var yii\web\View $this */
/** @var app\models\Pasos $model */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Pasos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="Pasos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    
    <div class="d-flex flex-wrap">
    <?= Html::img($model->getImgUrl(),[
        'class' => 'img-fluid col-md-6'
    ]) ?>
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nombre',
            'color',
            'cita_biblica',
            [
                'attribute' => 'texto',
                'value' => BibliaController::getText($model->cita_biblica)
            ],
            'descripcion',

        ],
        'options' => [
            'class' => 'table table-striped table-bordered col-md-6']
        
    ]) ?>
    </div>
    
  
    <p></p>
    <div class="btn-right  btn-pasos">
            <?= Html::a(
                '<i class="fa-regular fa-file-pdf"></i>' .
                    "Descargar",
                ['download-pdf', 'id' => $model->id],
                ["class" => "btn btn-primary"]
            ) ?>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </div>

</div>

