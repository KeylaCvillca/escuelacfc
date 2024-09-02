<?php
/** @var string $filePath */
/** @var string $mimeType */
/** @var string $extension */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Visualizar archivo';
$this->params['breadcrumbs'][] = ['label' => 'Archivos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="file-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="file-content">
        <?php if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
            <img src="<?= $filePath ?>" alt="Imagen" style="max-width: 100%;">
        <?php elseif (in_array($extension, ['mp4', 'webm', 'ogg'])): ?>
            <video controls style="max-width: 100%;">
                <source src="<?= $filePath ?>" type="<?= $mimeType ?>">
                Tu navegador no soporta la reproducción de videos.
            </video>
        <?php elseif (in_array($extension, ['pdf'])): ?>
            <embed src="<?= Yii::getAlias('@web') . '/' . $filePath ?>" type="<?= $mimeType ?>" width="100%" height="600px">
        <?php elseif (in_array($extension, ['xls', 'xlsx'])): ?>
            <p>Los archivos xls y xlsx no se pueden visualizar.</p>

        <?php else: ?>
            <p>Vista previa no disponible para este tipo de archivo.</p>
            <a href="<?= Yii::getAlias('@web') . '/' . $filePath ?>" class="btn btn-primary" download>Descargar Archivo</a>
        <?php endif; ?>
    </div>
</div>
