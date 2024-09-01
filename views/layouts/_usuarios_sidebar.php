<?php
use yii\helpers\Html;
use app\assets\MenuHelper;

$ALIASES = [
    'usuarios' => 'usuario',
    'ensenan' => 'función',
    'telefonos' => 'teléfono'
];


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
<div class="action-group d-flex flex-column justify-content-evenly" style="padding:10px">
    <?php

    if ($actionId === 'index') {
        // Index view
echo Html::a('Añadir ' . $ALIASES[$controller], ['create'], ['class' => 'list-group-item list-group-item-action btn btn-success', 'style' => 'margin-bottom: 10px;']);
    } elseif ($actionId === 'create' || $actionId === 'upload') {
        // Añadir view
        echo Html::a('Volver a principal', ['index'], ['class' => ' list-group-item list-group-item-action btn btn-primary', 'style' => 'margin-bottom: 10px;']);
    } elseif ($actionId === 'view') {
        // View view
        echo Html::a('Volver a principal', ['index'], ['class' => ' list-group-item list-group-item-action btn btn-primary', 'style' => 'color: #ffffff;margin-bottom: 10px;']);
        echo Html::a('Añadir ' . $ALIASES[$controller], ['create'], ['class' => ' list-group-item list-group-item-action btn btn-success', 'style' => 'color: #ffffff;margin-bottom: 10px;']);
        echo Html::a('Editar ' . $ALIASES[$controller], ['update', 'id' => Yii::$app->request->get('id')], ['class' => ' list-group-item list-group-item-action btn btn-warning', 'style' => 'color: #ffffff;margin-bottom: 10px;']);
        echo Html::a('Eliminar ' . $ALIASES[$controller], ['delete', 'id' => Yii::$app->request->get('id')],
            [
                'class' => ' list-group-item list-group-item-action btn btn-danger',
                'style' => 'margin-bottom: 10px;color: #ffffff;',
                'data' => [
                    'method' => 'post',
                    'confirm' => '¿Seguro que quieres eliminar este elemento?'
            ]
            ]
        );    } elseif ($actionId === 'update') {
        // Editar view
        echo Html::a('Ver '  . $ALIASES[$controller], ['view', 'id' => Yii::$app->request->get('id')], ['class' => ' list-group-item list-group-item-action btn btn-info', 'style' => 'color: #ffffff;margin-bottom: 10px;']);
        echo Html::a('Eliminar ' . $ALIASES[$controller], ['delete', 'id' => Yii::$app->request->get('id')],
            [
                'class' => ' list-group-item list-group-item-action btn btn-danger',
                'style' => 'margin-bottom: 10px;color: #ffffff;',
                'data' => [
                    'method' => 'post',
                    'confirm' => '¿Seguro que quieres eliminar este elemento?'
            ]
            ]
        );        echo Html::a('Añadir ' . $ALIASES[$controller], ['create'], ['class' => ' list-group-item list-group-item-action btn btn-success', 'style' => 'color: #ffffff;margin-bottom: 10px;']);
    }
    if ($actionId != 'upload') {
        echo Html::a('Añadir usuarios desde Excel', ['usuarios/upload'], ['class' => ' list-group-item list-group-item-action btn btn-success', 'style' => 'margin-bottom: 10px;color: #ffffff;']);
    }
    
?>
</div>