<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SearchForm */
/* @var $text string */

?>

<div class="biblia-search-result">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_searchForm', ['model' => $model]) ?>

    <?php if ($text !== null): ?>
        <div class="alert alert-success">
            <p><strong>Versículo encontrado:</strong></p>
            <p><?= Html::encode($text) ?></p>
        </div>
    <?php else: ?>
        <?php if ($model->quote): ?>
            <div class="alert alert-warning">
                <p>No se encontró el versículo.</p>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
