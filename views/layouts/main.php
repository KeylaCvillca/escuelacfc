<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use app\controllers\UsuariosController;
use app\assets\MenuHelper;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
        ],
    ]);
    echo MenuHelper::navMenu();
    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?php if (MenuHelper::sideBar('rbac')): ?>
            <div class="col-md-3">
                <?= $this->render('_rbac_sidebar') ?>
            </div>
            <div class="col-md-9">
                <?= $content ?>
            </div>
        <?php elseif (MenuHelper::sideBar('usuarios')): ?>
            <div class="col-md-3">
                <?= $this->render('_usuarios_sidebar') ?>
            </div>
            <div class="col-md-9">
                <?= $content ?>
            </div>
        <?php elseif (MenuHelper::sideBar('materiales')): ?>
            <div class="col-md-3">
                <?= $this->render('_materiales_sidebar') ?>
            </div>
            <div class="col-md-9">
                <?= $content ?>
            </div>

        <?php else: ?>
            <div class="col-md-12">
                <?= $content ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <p class="float-left">&copy; My Company <?= date('Y') ?></p>
        <p class="float-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
