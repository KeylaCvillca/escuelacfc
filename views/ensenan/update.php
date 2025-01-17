<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Ensenan $model */

$this->title = 'Editar Ensenan: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ensenans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="ensenan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
