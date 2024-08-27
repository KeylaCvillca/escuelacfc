<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mis Noticias';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="noticias-misnoticias">

    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Html::a('Escribir Nueva Noticia', ['create'], ['class' => 'btn btn-success']) ?></p>

    <?php if ($dataProvider->totalCount > 0): ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'titulo',
                [
                    'attribute' => 'fecha',
                    'format' => ['date', 'php:d-m-Y'],
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
                        },
                    ],
                ],
            ],
        ]) ?>

    <?php else: ?>
        <p>Aún no has publicado ninguna noticia.</p>
    <?php endif; ?>

</div>
