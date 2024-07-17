<?php
/* @var $this yii\web\View */
/* @var $verse string */
/* @var $indice array */

use yii\helpers\Html;

$this->title = 'Biblia';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="biblia-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="verse">
        <h2>Versículo del día</h2>
        <p><?= Html::encode($verse) ?></p>
    </div>
    
    <?= $this->render('_searchform', ['model' => new \app\models\ConsultaBiblica()]) ?>

    <div class="indice">
        <h2>Índice</h2>
        <ul>
            <?php foreach ($indice as $item): ?>
                <li><?= Html::encode(implode($item)) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
