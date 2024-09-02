<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Mis Alumnas';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="alumnas-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($dataProvider === null || $dataProvider->getTotalCount() === 0): ?>
        <p>No hay alumnas en los niveles asignados.</p>
    <?php else: ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'nombre_apellidos',
                'celula',
                'email:email',
                'color',
                [
                    'label' => 'Teléfonos',
                    'value' => function($model) {
                        return implode(', ', array_column($model->telefonos, 'telefono'));
                    },
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}', 

                ],
            ],
        ]); ?>
    <?php endif; ?>
</div>
