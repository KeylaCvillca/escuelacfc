<?php
use yii\grid\GridView;
use yii\helpers\Html;
use app\models\Niveles;
use yii\grid\ActionColumn;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $pasos array */
/* @var $niveles array */

?>

<h1>Pasos by Nivel Color</h1>

<?php foreach ($niveles as $nivel): ?>
    <h2><?= Html::encode($nivel->color) ?></h2>
    
    <?= GridView::widget([
        'dataProvider' => $pasos[$nivel->color],
        'columns' => [
            // Customize the columns as needed
            'nombre',
            'cita_biblica', // Example column
            'descripcion',
            [
                'header' => Yii::t('yii2mod.rbac', 'Action'),
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, $model, $key, $index) {
                // Here, we explicitly reference the AuthItem model class
                return Url::to([$action, 'id' => $model->id]);
            }]
        ],
    ]); ?>
<?php endforeach; ?>
