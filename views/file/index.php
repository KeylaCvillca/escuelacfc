<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Archivos Multimedia';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="file-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'name',
            'extension',
            [
                'attribute' => 'path',
                'label' => 'Ruta',
                'value' => function ($model) {
                    return $model->path;
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {download} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('Ver', ['view', 'path' => $model->path], ['class' => 'btn btn-primary']);
                    },
                    'download' => function ($url, $model) {
                        return Html::a('Descargar', ['download', 'path' => $model->path], ['class' => 'btn btn-success']);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('Eliminar', ['delete', 'path' => $model->path], [
                            'class' => 'btn btn-danger',
                            'data-confirm' => '¿Estás seguro de que deseas eliminar este archivo?',
                            'data-method' => 'post',
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
