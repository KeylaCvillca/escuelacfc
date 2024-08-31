<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent" style="height: 100vh; background-image: url('<?= Yii::getAlias('@web/imagenes/banner.png') ?>'); background-size: cover; background-position: center; display: flex; justify-content: center; align-items: center;">
        <div style="background-color: rgba(0, 0, 0, 0.5); padding: 20px; border-radius: 10px;">
            <h1 class="display-4 text-white">Escuela de Danza</h1>
            <p class="lead text-white">Centro Familiar Cristiano Santander</p>
        </div>
    </div>

    
    <div class="body-content">
        <div class="jumbotron d-flex justify-content-center bg-transparent pb-2">
            <h2>Instrumentos</h2>
        </div>

        <div class="row">
            <?php foreach ($instrumentos as $instrumento): ?>
                <div class="col-lg-3">
                    <div class="card" style="height:400px; background-image: url('<?= Yii::getAlias('@web/imagenes/instrumentos/' . $instrumento->nombre . ".jpg") ?>'); background-size: cover; background-position: center; transition: transform 0.3s;">
                        <div class="card-body d-flex flex-column justify-content-end" style="background-color: rgba(255, 255, 255, 0.65);">
                            <h2 class="card-title"><?= Html::encode($instrumento->nombre) ?></h2>
                            <p><a class="btn btn-outline-secondary" href="<?= Url::to(['instrumentos/view', 'id' => $instrumento->id]) ?>">Ver detalles &raquo;</a></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
    
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
                Fecha de publicación: <?= $noticia->getFechaFormateada() ?>
            </p>
        </div>
    </div>
<?php endforeach; ?>
</div>
<?php
// Añadimos los estilos de hover al final del archivo para hacer que las tarjetas se agranden al pasar el ratón
$this->registerCss("
    .card:hover {
        transform: scale(1.05);
    }
");
?>