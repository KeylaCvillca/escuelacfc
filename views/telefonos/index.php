<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use app\models\Telefonos;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\TelefonosSearch $searchModel */

$this->title = 'Telefonos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="telefonos-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['attribute' => 'nombre_apellidos',
             'label' => 'Nombre Apellidos',
             'value' => function($model) {
                    return $model->getUsuarioAttribute('nombre_apellidos'); // Adjust based on your data
                },
            ],
            ['attribute' => 'usuario_email',
             'label' => 'Email',
             'value' => function($model) {
                    return $model->getUsuarioAttribute('email');
                },
            ],
            ['attribute' => 'usuario_username',
             'label' => 'Username',
             'value' => function($model) {
                    return $model->getUsuarioAttribute('username');                },
            ],

            'telefono',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Telefonos $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

</div>
