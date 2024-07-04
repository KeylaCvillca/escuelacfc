<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Utilizan $model */

$this->title = 'Update Utilizan: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Utilizans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="utilizan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
