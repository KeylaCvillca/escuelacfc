<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Niveles $model */

$this->title = 'Editar Niveles: ' . $model->color;
$this->params['breadcrumbs'][] = ['label' => 'Niveles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->color, 'url' => ['view', 'color' => $model->color]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="Niveles-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
