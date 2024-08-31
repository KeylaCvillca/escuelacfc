<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FileSearch */
/* @var $dataProvider yii\data\ArrayDataProvider */

?>
<div class="file-index">

    <h1>Archivos Multimedia</h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'name',
                'label' => 'Nombre',
                'filter' => Html::activeTextInput($searchModel, 'name', ['class' => 'form-control']),
            ],
            [
                'attribute' => 'extension',
                'label' => 'Extensión',
                'filter' => Html::activeTextInput($searchModel, 'extension', ['class' => 'form-control']),
            ],
            [
                'attribute' => 'path',
                'label' => 'Ruta',
                'value' => function ($model) {
                    return $model->path;
                },
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
