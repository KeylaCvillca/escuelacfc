<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="sidebar">
    <ul class="nav nav-pills nav-stacked">
        <li><?= Html::a('Permissions', Url::to(['/rbac/permission/index'])) ?></li>
        <li><?= Html::a('Roles', Url::to(['/rbac/role/index'])) ?></li>
        <li><?= Html::a('Assignments', Url::to(['/rbac/assignment/index'])) ?></li>
        <li><?= Html::a('Rules', Url::to(['/rbac/rule/index'])) ?></li>
    </ul>
</div>
