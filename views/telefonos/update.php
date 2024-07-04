<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Telefonos $model */

$this->title = 'Update Telefonos: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Telefonos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="telefonos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
