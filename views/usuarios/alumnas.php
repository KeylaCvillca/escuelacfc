<?php
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

/* @var $this yii\web\View */
/* @var $alumnasPorNivel array */

$this->title = 'Alumnas por Nivel';

?>

<div class="alumnas-por-nivel">

    <h1><?= \yii\helpers\Html::encode($this->title) ?></h1>

    <?php foreach ($alumnasPorNivel as $nivel => $alumnas): ?>
        <h2><?= "Nivel: " . \yii\helpers\Html::encode($nivel) ?></h2>

        <?= GridView::widget([
            'dataProvider' => new ArrayDataProvider([
                'allModels' => $alumnas,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]),
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'nombre',
                'email',
                'telefono',

                // Otras columnas según tu modelo Usuarios
            ],
        ]); ?>
    <?php endforeach; ?>

</div>

