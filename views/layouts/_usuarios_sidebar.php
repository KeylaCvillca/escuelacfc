<?php
use yii\helpers\Html;

$isAdmin = Yii::$app->user->can('admin');
?>

<div class="list-group">
    <?php if ($isAdmin): ?>
        <?= Html::a('Usuarios', ['usuarios/index'], ['class' => 'list-group-item list-group-item-action']) ?>
        <?= Html::a('Funciones', ['ensenan/index'], ['class' => 'list-group-item list-group-item-action']) ?>
        <?= Html::a('Teléfonos', ['telefonos/index'], ['class' => 'list-group-item list-group-item-action']) ?>
    <?php endif; ?>
</div>
