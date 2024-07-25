<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\LinkPager;

/** @var yii\web\View $this */
/** @var app\models\Noticias $model */

\yii\web\YiiAsset::register($this);
?>
<div class="noticias-read container mt-4">

    <h2 class="mb-4 text-center">Noticias</h2>

    <?php foreach ($noticias as $noticia): ?>
    <div class="row mb-3 news-item">
        <div class="col-md-8">
            <h3><?= Html::encode($noticia->titulo) ?></h3>
            <p class="text-muted">
                Autor: <?= Html::encode($noticia->autorNombreApellidos) ?>
            </p>
            <p style="text-align: justify;">
                <?= nl2br(Html::encode($noticia->contenido)) ?>
            </p>
        </div>
        <div class="col-md-4 text-right">
            <p class="text-muted">
                Fecha de publicación: <?= Yii::$app->formatter->asDate($noticia->fecha_publicacion, 'long') ?>
            </p>
        </div>
    </div>
<?php endforeach; ?>

<!-- Paginación -->
<div class="pagination">
    <?= LinkPager::widget([
        'pagination' => $pagination,
        'options' => ['class' => 'pagination'],
        'linkOptions' => ['class' => 'page-link'],
        'pageCssClass' => 'page-item',
    ]) ?>
</div>

</div>