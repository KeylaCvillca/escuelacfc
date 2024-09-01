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
    <div class="d-flex">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="btn-right  btn-pasos" style="margin-left:40px">
            <?= Html::a(
                '<i class="fa-regular fa-file-pdf" style="color:#ffffff; margin-right:4px"></i>' .
                        "Descargar",
                    ['download-pdf', 'id' => $model->id],
                    ["class" => "btn btn-primary", "style" => "margin-top:2.5vh;"]
                ) ?>
        </div>
    </div>
    <div class="d-flex flex-wrap flex-row-reverse">
    
    
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
                'label' => 'Patrón',
                'format' => 'raw',
                'value' => function($model) {
                    return Html::img($model->getImgUrl(),[
                    'class' => 'img-fluid',
                    'style' => 'max-width: 35vw'

                ]);
            }
            ]

        ],
        'options' => [
            'class' => 'table table-striped table-bordered']
        
    ]) ?>
    </div>
    
   <?php if (!empty($model->utilizans)): ?>
    <div class="d-flex flex-wrap justify-content-between">
        <?php foreach ($model->utilizans as $utilizan): ?>
            <?php if (!empty($utilizan->video)): ?>
            <div>
                <div class="video-container " style="margin: 10px">
                    <video width="320" height="240" controls>
                        <?= Html::tag('source', '', [
                            'src' => Yii::getAlias('@web/videos/pasos/') . $utilizan->video,
                            'type' => 'video/webm',
                        ]) ?>
                        <?= Yii::t('app', 'Your browser does not support the video tag.') ?>
                    </video>
                </div>
                <h6><?= Html::a($utilizan->getNombreInstrumento(), ['instrumentos/view', 'id' => $utilizan->instrumento], ['class' => 'list-group-item list-group-item-action', 'style' => 'width:320px']) ?>
                </h6>
            </div>
                
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
        <p><?= Yii::t('app', 'No hay vídeos asociados a este paso.') ?></p>
    <?php endif; ?>


</div>

