<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Pasos $model */

$this->title = 'Actualizar Paso: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Pasos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="Pasos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
