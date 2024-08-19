<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $searchModel app\models\EnsenanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gestionar Maestras';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="maestras-gestion">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Asignar Nueva Función', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // Renderizamos una tabla para gestionar maestras, niveles y funciones ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'maestra',
                'label' => 'Maestra',
                'value' => function($model) {
                    return $model->usuario->nombre_apellidos;
                },
                'filter' => Html::activeDropDownList($searchModel, 'maestra', \yii\helpers\ArrayHelper::map(\app\models\Usuarios::find()->where(['rol' => 'maestra'])->all(), 'id', 'nombre_apellidos'), ['class' => 'form-control', 'prompt' => 'Seleccione Maestra']),
            ],
            [
                'attribute' => 'color',
                'label' => 'Nivel',
                'value' => function($model) {
                    return $model->nivel->color;
                },
                'filter' => Html::activeDropDownList($searchModel, 'color', \yii\helpers\ArrayHelper::map(\app\models\Niveles::find()->all(), 'id', 'color'), ['class' => 'form-control', 'prompt' => 'Seleccione Nivel']),
            ],
            [
                'attribute' => 'funcion',
                'label' => 'Función',
                'filter' => Html::activeTextInput($searchModel, 'funcion', ['class' => 'form-control']),
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
