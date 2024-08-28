<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="sidebar">
    <ul class="nav nav-pills nav-stacked">
        <li><?= Html::a('Rutas', Url::to(['/rbac/route/index'])) ?></li>
        <li><?= Html::a('Permisos', Url::to(['/rbac/permission/index'])) ?></li>
        <li><?= Html::a('Roles', Url::to(['/rbac/role/index'])) ?></li>
        <li><?= Html::a('Asignaciones', Url::to(['/rbac/assignment/index'])) ?></li>
        <li><?= Html::a('Reglas', Url::to(['/rbac/rule/index'])) ?></li>
    </ul>
</div>
