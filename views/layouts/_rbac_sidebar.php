<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\MenuHelper;

$controller = Yii::$app->controller->id;
?>

<h4><?=MenuHelper::sideBarTitle($controller)?></h4>
<div class="sidebar">
    <ul class="nav nav-pills nav-stacked flex-column">
        <li><?= Html::a('Rutas', Url::to(['/rbac/route/index']),['class' => 'list-group-item list-group-item-action']) ?></li>
        <li><?= Html::a('Permisos', Url::to(['/rbac/permission/index']),['class' => 'list-group-item list-group-item-action']) ?></li>
        <li><?= Html::a('Roles', Url::to(['/rbac/role/index']),['class' => 'list-group-item list-group-item-action']) ?></li>
        <li><?= Html::a('Asignaciones', Url::to(['/rbac/assignment/index']),['class' => 'list-group-item list-group-item-action']) ?></li>
        <li><?= Html::a('Reglas', Url::to(['/rbac/rule/index']),['class' => 'list-group-item list-group-item-action']) ?></li>
    </ul>
</div>