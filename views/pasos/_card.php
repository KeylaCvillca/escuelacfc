<?php
use yii\helpers\Html;

/* @var $model app\models\Pasos */
?>

<div class="card shadow-sm">
    <div class="card-header bg-secondary text-white">
        <h5 class="card-title" style="color:var(--primary)"><?= Html::encode($model->nombre) ?></h5>
        <small><strong>Nivel:</strong> <?= Html::encode($model->color) ?></small>
    </div>
    <div class="card-body">
        <p><strong>Cita Bíblica:</strong> <?= Html::encode($model->cita_biblica) ?></p>
        <?php if ($model->imagen): ?>
        <img src="<?= Html::encode($model->getImgUrl()) ?>" class="img-fluid mb-3" alt="<?= Html::encode($model->nombre) ?>">
        <?php endif; ?>
        <p><strong>Instrumentos:</strong></p>
        <ul class="list-unstyled">
            <?php foreach ($model->instrumentos as $instrumento): ?>
                <li>- <?= Html::encode($instrumento->nombre) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="card-footer text-center">
        <?= Html::a('Ver', ['view', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php if (Yii::$app->user->can('maestra') || Yii::$app->user->can('admin')): ?>
            <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
            <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => '¿Estás seguro de que deseas eliminar este paso?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
    </div>
</div>
