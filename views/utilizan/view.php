<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Utilizan $model */

$this->title = $model->getNombrePaso() . ': ' . $model->getNombreInstrumento();
$this->params['breadcrumbs'][] = ['label' => 'Utilizans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="utilizan-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'nombre_paso',
                'label' => 'Paso',
                'value' => function($model) {
                    return $model->getNombrePaso(); // Usamos el método del modelo
                },
            ],
            [
                'attribute' => 'nombre_instrumento',
                'label' => 'Instrumento',
                'value' => function($model) {
                    return $model->getNombreInstrumento(); // Usamos el método del modelo
                },
            ],
            'video',
        ],
    ]) ?>
    <?php echo '<div class="video-container">'
                . '<video width="320" height="240" controls>'
                . '<source src="' . Yii::getAlias('@web/videos/pasos/') . $model->video . '" type="video/webm">'
                . 'Your browser does not support the video tag.'
                . '</video>'
                . '</div>';
?>
</div>
