<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\db\ActiveQuery;

$this->title = 'Funciones';
?>
<div class="ensenan-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Html::a('Create Ensenan', ['create'], ['class' => 'btn btn-success']) ?></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'nombre',
                'label' => 'Maestra',
            ],
            'color',
            'funcion',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
