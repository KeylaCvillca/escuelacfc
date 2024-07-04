<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Utilizan $model */

$this->title = 'Create Utilizan';
$this->params['breadcrumbs'][] = ['label' => 'Utilizans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="utilizan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
