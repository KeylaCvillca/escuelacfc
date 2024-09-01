<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Instrumentos;
use app\models\Pasos;

$this->title = 'Vídeos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="utilizan-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'nombre_instrumento',
                'label' => 'Instrumento',
                'value' => function($model) {
                    return $model->getNombreInstrumento(); // Usamos el método del modelo
                },
                'filter' => ArrayHelper::map(Instrumentos::find()->asArray()->all(), 'id', 'nombre'),
            ],

            [
                'attribute' => 'nombre_paso',
                'label' => 'Paso',
                'value' => function($model) {
                    return $model->getNombrePaso(); // Usamos el método del modelo
                },
                'filter' => ArrayHelper::map(Pasos::find()->asArray()->all(), 'id', 'nombre'),
            ],

            [
                'attribute' => 'video',
                'label' => 'Vídeo',
            ],

            ['class' => 'yii\grid\ActionColumn',
             'template' => '{view} {delete}'
            ],
        ],
        'summary' => ''
    ]); ?>
</div>
