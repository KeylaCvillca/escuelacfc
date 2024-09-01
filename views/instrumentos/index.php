<?php

use app\models\Instrumentos;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Instrumentos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="Instrumentos-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'nombre',
            'significado',
            'cita_biblica',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Instrumentos $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
