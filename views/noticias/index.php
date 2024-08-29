<?php

use app\models\Noticias;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Noticias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="noticias-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'titulo',
            [
                'attribute' => 'autor',
                'value' => function($model) {
                    return $model->getAutorNombreApellidos();
                }
            ],
            'contenido',
            [
                'attribute' => 'publico',
                'label' => 'Público',
                'value' => function($model) {
                    return $model->publico == 0? "No":"Sí";
                }
            ],
            [
                'attribute' => 'fecha_publicacion',
                'value' => function($model) {
                return $model->getFechaFormateada();
                }
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Noticias $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
