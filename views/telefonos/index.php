<?php

use app\models\Telefonos;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Telefonos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="telefonos-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'telefono',
            ['attribute' => 'nombre_apellidos',
             'label' => 'Nombre y apellidos',
             'value' => function($model) {
                    return $model->getUsuarioAttribute('nombre_apellidos'); // Usamos el método del modelo
                },
            ],
            ['attribute' => 'email',
             'label' => 'Email',
             'value' => function($model) {
                    return $model->getUsuarioAttribute('email'); // Usamos el método del modelo
                },
            ],
            ['attribute' => 'username',
             'label' => 'Username',
             'value' => function($model) {
                    return $model->getUsuarioAttribute('username'); // Usamos el método del modelo
                },
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Telefonos $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
        'summary' => ''
    ]); ?>


</div>
