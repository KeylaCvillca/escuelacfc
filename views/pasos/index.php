<?php
use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PasosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pasos';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>
<div class="d-flex justify-content-around">
    <?php if (Yii::$app->user->can('maestra') || Yii::$app->user->can('admin')): ?>
            <p>
                <?= Html::a('Añadir paso', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <p>
                <?= Html::a('Añadir vídeo', ['utilizan/create'], ['class' => 'btn btn-success']) ?>
            </p>
            <p>
                <?= Html::a('Añadir instrumento', ['instrumentos/create'], ['class' => 'btn btn-success']) ?>
            </p>
    <?php endif; ?>
    <div class="pasos-search">
        <?= $this->render('_search', ['model' => $searchModel]); ?>
    </div>
</div>


<div class="pasos-index">
    <div class="row d-flex">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item col-md-4'],
            'layout' => "{items}",
            'itemView' => function ($model, $key, $index, $widget) {
                return $this->render('_card', ['model' => $model]);
            },
        ]); ?>
    </div>
</div>
