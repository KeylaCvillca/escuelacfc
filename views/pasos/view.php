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

    
    <div class="d-flex flex-wrap flex-row-reverse">
    <div class="col-md-6">
        <?= Html::img($model->getImgUrl(),[
            'class' => 'img-fluid'
        ]) ?>
        <div class="btn-right  btn-pasos">
            <?= Html::a(
                '<i class="fa-regular fa-file-pdf"></i>' .
                        "Descargar",
                    ['download-pdf', 'id' => $model->id],
                    ["class" => "btn btn-primary"]
                ) ?>
        </div>
    </div>
    
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
            [
                'label' => 'Instrumentos',
                'value' => $model->getInstrumentosNombres()
            ]

        ],
        'options' => [
            'class' => 'table table-striped table-bordered col-md-6']
        
    ]) ?>
    </div>
    
  
    <p></p>
    
    
    
   <?php if (!empty($model->utilizans)): ?>
        <?php foreach ($model->utilizans as $utilizan): ?>
            <?php if (!empty($utilizan->video)): ?>
            <div>
                <div class="video-container">
                    <video width="320" height="240" controls>
                        <?= Html::tag('source', '', [
                            'src' => Yii::getAlias('@web/videos/pasos/') . $utilizan->video,
                            'type' => 'video/webm',
                        ]) ?>
                        <?= Yii::t('app', 'Your browser does not support the video tag.') ?>
                    </video>
                </div>
                <h6><?= Html::a($utilizan->getNombreInstrumento(),"instrumentos/view",["id"=>$utilizan->instrumento, "class" =>'list-group-item list-group-item-action', "style" => "width:320px"])?></h6>
            </div>
                
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <p><?= Yii::t('app', 'No hay vídeos asociados a este paso.') ?></p>
    <?php endif; ?>


</div>

