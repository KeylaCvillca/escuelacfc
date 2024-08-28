<?php
/* @var $this yii\web\View */
/* @var $alumnasPorNivel array */

use yii\helpers\Html;

$this->title = 'Alumnas por Nivel';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="alumnas-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (empty($alumnasPorNivel)): ?>
        <p>No hay alumnas en los niveles asignados.</p>
    <?php else: ?>
        <?php foreach ($alumnasPorNivel as $color => $alumnas): ?>
            <h2>Color: <?= Html::encode($color) ?></h2>
            <ul>
                <?php foreach ($alumnas as $alumna): ?>
                    <li><?= Html::encode($alumna->nombre) ?> (<?= Html::encode($alumna->email) ?>)</li>
                <?php endforeach; ?>
            </ul>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
