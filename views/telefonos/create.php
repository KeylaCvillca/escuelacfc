<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Telefonos $model */

$this->title = 'Create Telefonos';
$this->params['breadcrumbs'][] = ['label' => 'Telefonos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="telefonos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
