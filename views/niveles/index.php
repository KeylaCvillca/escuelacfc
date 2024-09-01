<?php

use app\models\Niveles;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Niveles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="Niveles-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Añadir Niveles', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'color',
            'descripcion',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Niveles $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'color' => $model->color]);
                 }
            ],
        ],
    ]); ?>


</div>
