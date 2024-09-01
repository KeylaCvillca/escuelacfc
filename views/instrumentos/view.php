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
    <div class='d-flex'>
        <img src="<?= Yii::getAlias('@web') . '/imagenes/instrumentos/' . strtolower($model->nombre) . '.jpg' ?>"
        alt="<?= Html::encode($model->nombre) ?>" class="col-md-2" style="border-radius: 10px !important; overflow:hidden !important;padding:0 !important;margin-right:10px">
    
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
    </div>
    
       
    <h2>Pasos relacionados</h2>
    <?= GridView::widget([
            'dataProvider' => $pasos,
            'columns' => [
                'nombre',
                'color',
                'cita_biblica',            
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => Yii::$app->user->identity->getRole() == 'alumna' ? '{view} {downloadPdf}' : '{view} {update} {delete}',
                    'urlCreator' => function ($action, $model, $key, $index) {
                        return ['pasos/' . $action, 'id' => $model->id];
                    },
                    'buttons' => [
                            'downloadPdf' => function ($url, $model) {
                                return Html::a('<i class="bi bi-download"></i>', ['pasos/download-pdf', 'id' => $model->id], [
                                    'title' => 'Descargar PDF',
                                    'aria-label' => 'Descargar PDF',
                                    'data-pjax' => '0',
                            ]);
                        
                        },
                    ]
                ],
            ],
            'summary' => ''
    ]);?>

</div>
