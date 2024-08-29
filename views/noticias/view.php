<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Noticias $model */

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Noticias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="noticias-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'titulo',
            'fecha_publicacion',
            'contenido',
            [
                'label' => 'Autor',
                'value' => $autorNombreApellidos, // Usamos la relación para obtener el nombre completo del autor
            ],
            'publico:boolean',
        ],
    ]) ?>

</div>
