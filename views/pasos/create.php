<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Pasos $model */

$this->title = 'Create Pasos';
$this->params['breadcrumbs'][] = ['label' => 'Pasos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="Pasos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
