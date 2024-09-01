<?php
use yii\helpers\Html;
use yii\helpers\Json;
use yii2mod\rbac\RbacRouteAsset;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\grid\ActionColumn; // Ensure this is included
use yii\helpers\Url;
use yii2mod\rbac\models\AuthItemModel;

RbacRouteAsset::register($this);

/* @var $this yii\web\View */
/* @var $routes array */

$this->title = "Rutas Disponibles";
?>
<h1><?php echo Html::encode($this->title); ?></h1>
<?php echo Html::a(Yii::t('yii2mod.rbac', 'Refresh'), ['refresh'], [
    'class' => 'btn btn-primary',
    'id' => 'btn-refresh',
]); ?>
<?php echo $this->render('../../vendor/yii2mod/yii2-rbac/views/_dualListBox', [
    'opts' => Json::htmlEncode([
        'items' => $routes,
    ]),
    'assignUrl' => ['assign'],
    'removeUrl' => ['remove'],
]); ?>
<div class="item-index">
    <h1>Permisos</h1>
    <p>
        <?php echo Html::a(Yii::t('yii2mod.rbac', 'Añadir ' . $labels['Item']), ['create'], ['class' => 'btn btn-success']); ?>
    </p>
    <?php Pjax::begin(['timeout' => 5000, 'enablePushState' => false]); ?>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'name',
                'label' => Yii::t('yii2mod.rbac', 'Name'),
            ],
            [
                'attribute' => 'description',
                'format' => 'ntext',
                'label' => Yii::t('yii2mod.rbac', 'Description'),
            ],
            [
                'header' => Yii::t('yii2mod.rbac', 'Action'),
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, $model, $key, $index) {
                // Here, we explicitly reference the AuthItem model class
                return Url::to(["/rbac/role/$action", 'id' => $model->name]);
            },
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
</div>
