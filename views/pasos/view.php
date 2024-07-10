<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\controllers\BibliaController;

/** @var yii\web\View $this */
/** @var app\models\Pasos $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pasos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="Pasos-view">

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
            'id',
            'cita_biblica',
            'nombre',
            'descripcion',
            'imagen',
            'color',
        ],
    ]) ?>
    
    <p><?=BibliaController::getVersiculo($model->cita_biblica)?></p>

</div>
