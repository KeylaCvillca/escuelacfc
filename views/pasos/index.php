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

<?= $this->render('_search', ['model' => $searchModel]); ?>

<div class="pasos-index">
    <div class="row d-flex">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item col-md-4 col-sm-6 mb-4'],
            'layout' => "{items}",
            'itemView' => function ($model, $key, $index, $widget) {
                return $this->render('_card', ['model' => $model]);
            },
            'options' => [
                'class' => 'd-flex flex-wrap' 
            ]
        ]); ?>
    </div>
</div>
