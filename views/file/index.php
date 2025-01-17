<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FileSearch */
/* @var $dataProvider yii\data\ArrayDataProvider */
?>

<div class="file-index">
    <h1>Archivos Multimedia</h1>
    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['index'],
        'options' => ['class' => 'form-inline row  d-flex flex-wrap justify-content-around'],
    ]); ?>

    <?= $form->field($searchModel, 'name')->textInput(['placeholder' => 'Buscar por Nombre'])->label('') ?>
    <?= $form->field($searchModel, 'extension')->textInput(['placeholder' => 'Buscar por Extensión'])->label('') ?>
    <?= $form->field($searchModel, 'path')->textInput(['placeholder' => 'Buscar por Ruta'])->label('') ?>

    <div class="form-group d-flex justify-content-between" style="margin-top: -1vh;">
    <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary', 'style' => 'margin-right:1vw']) ?>
    <?= Html::a('Restablecer', ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>
    

    <?php ActiveForm::end(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'name',
                'label' => 'Nombre',
            ],
            [
                'attribute' => 'extension',
                'label' => 'Extensión',
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
                        return Html::a('<i class="bi bi-eye"></i>', ['view', 'path' => $model->path], [
                           
                            'title' => 'Ver',
                            'aria-label' => 'Ver',
                            'data-pjax' => '0',
                        ]);
                    },
                    'download' => function ($url, $model) {
                        return Html::a('<i class="bi bi-download"></i>', ['download', 'path' => $model->path], [
                         
                            'title' => 'Descargar',
                            'aria-label' => 'Descargar',
                            'data-pjax' => '0',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<i class="bi bi-trash"></i>', ['delete', 'path' => $model->path], [
                            
                            'title' => 'Eliminar',
                            'aria-label' => 'Eliminar',
                            'data-confirm' => '¿Estás seguro de que deseas eliminar este archivo?',
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]);
                    },
                ],

            ],
        ],
    ]); ?>

</div>
