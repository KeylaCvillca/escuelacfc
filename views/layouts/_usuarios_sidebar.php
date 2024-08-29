<?php
use yii\helpers\Html;
use app\assets\MenuHelper;

$isAdmin = Yii::$app->user->can('admin');
$actionId = Yii::$app->controller->action->id;
$controller = Yii::$app->controller->id;
?>
<h4><?=MenuHelper::sideBarTitle($controller)?></h4>
<div class="list-group">
    <?php if ($isAdmin): ?>
        <?= Html::a('Usuarios', ['usuarios/index'], ['class' => 'list-group-item list-group-item-action']) ?>
        <?= Html::a('Funciones', ['ensenan/index'], ['class' => 'list-group-item list-group-item-action']) ?>
        <?= Html::a('Teléfonos', ['telefonos/index'], ['class' => 'list-group-item list-group-item-action']) ?>
    <?php endif; ?>
</div>
<h4>Acciones</h4>
<div class="action-group">
    <?php

    if ($actionId === 'index') {
        // Index view
        echo Html::a('Create', ['create'], ['class' => ' list-group-item list-group-item-action btn btn-success']);
    } elseif ($actionId === 'create') {
        // Create view
        echo Html::a('Back to Index', ['index'], ['class' => ' list-group-item list-group-item-action btn btn-success']);
    } elseif ($actionId === 'view') {
        // View view
        echo Html::a('Create', ['create'], ['class' => ' list-group-item list-group-item-action btn btn-success']);
        echo Html::a('Update', ['update', 'id' => Yii::$app->request->get('id')], ['class' => ' list-group-item list-group-item-action btn btn-success']);
        echo Html::a('Delete', ['delete', 'id' => Yii::$app->request->get('id')], ['class' => ' list-group-item list-group-item-action btn btn-danger']);
    } elseif ($actionId === 'update') {
        // Update view
        echo Html::a('View', ['view', 'id' => Yii::$app->request->get('id')], ['class' => ' list-group-item list-group-item-action btn btn-info']);
        echo Html::a('Delete', ['delete', 'id' => Yii::$app->request->get('id')], ['class' => ' list-group-item list-group-item-action btn btn-danger']);
        echo Html::a('Create', ['create'], ['class' => ' list-group-item list-group-item-action btn btn-success']);
    }
    echo Html::a('Añadir usuarios desde Excel', ['usuarios/upload'], ['class' => ' list-group-item list-group-item-action btn btn-success']);
?>
</div>