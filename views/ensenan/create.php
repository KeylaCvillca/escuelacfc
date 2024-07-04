<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Ensenan $model */

$this->title = 'Create Ensenan';
$this->params['breadcrumbs'][] = ['label' => 'Ensenans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ensenan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
