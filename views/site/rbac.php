<?php

use yii\helpers\Html;
use yii\helpers\Json;
use yii2mod\rbac\RbacRouteAsset;

RbacRouteAsset::register($this);

/* @var $this yii\web\View */
/* @var $routes array */

$this->title = Yii::t('yii2mod.rbac', 'Routes');
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
