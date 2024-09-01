<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Instrumentos $model */

$this->title = 'Editar Instrumentos: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Instrumentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="Instrumentos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
