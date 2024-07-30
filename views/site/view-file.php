<?php

use yii\helpers\Html;

/* @var $filePath string */
/* @var $filename string */

$fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
?>

<div class="file-content">
    <?php if ($fileExtension === 'mp4'): ?>
        <video controls style="max-width: 100%;">
            <source src="<?= Yii::getAlias('@web/videos/' . $filename) ?>" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    <?php else: ?>
        <?= Html::img(Yii::getAlias('@web/imagenes/' . $filename), ['style' => 'max-width: 100%;']) ?>
    <?php endif; ?>
</div>
