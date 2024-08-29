<?php
use yii\helpers\Html;

$isAdmin = Yii::$app->user->can('admin');
$isMaestra = Yii::$app->user->can('maestra');
?>

<div class="list-group">
    <?php if ($isAdmin || $isMaestra): ?>
        <?= Html::a('Pasos', ['pasos/index'], ['class' => 'list-group-item list-group-item-action']) ?>
        <?= Html::a('Instrumentos', ['instrumentos/index'], ['class' => 'list-group-item list-group-item-action']) ?>
        <?= Html::a('Vídeos', ['utilizan/index'], ['class' => 'list-group-item list-group-item-action']) ?>
        <?= Html::a('Niveles', ['niveles/index'], ['class' => 'list-group-item list-group-item-action']) ?>
    <?php endif; ?>
    <?php if ($isAdmin): ?>
        <?= Html::a('Noticias', ['noticias/index'], ['class' => 'list-group-item list-group-item-action']) ?>
    <?php endif; ?>
</div>
