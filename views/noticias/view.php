<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Noticias $model */

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Noticias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="noticias-view">
    
    <h2><?=Html::encode($model->titulo)?></h2>
    <div class="row mb-3 news-item">
        <div class="col-md-8">
            <h3><?= Html::encode($model->titulo) ?></h3>
            <p class="text-muted">
                Autor: <?= Html::encode($model->autorNombreApellidos) ?>
            </p>
            <p style="text-align: justify;">
                <?= nl2br(Html::encode($model->contenido)) ?>
            </p>
        </div>
        <div class="col-md-4 text-right">
            <p class="text-muted">
                Fecha de publicación: <?= $model->getFechaFormateada() ?>
            </p>
        </div>
    </div>

</div>
