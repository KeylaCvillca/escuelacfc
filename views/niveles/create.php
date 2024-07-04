<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Niveles $model */

$this->title = 'Create Niveles';
$this->params['breadcrumbs'][] = ['label' => 'Niveles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="Niveles-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
