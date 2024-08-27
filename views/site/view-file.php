<?php

use yii\helpers\Html;

/* @var $filePath string */
/* @var $filename string */

$fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
?>

<div class="file-content">
    <?= File::display($file)?>
</div>
