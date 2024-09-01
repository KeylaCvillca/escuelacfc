<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Col;
use yii\bootstrap4\Row;
use app\assets\MenuHelper;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600&display=swap" rel="stylesheet">

    <?= $this->registerCssFile('@web/css/colors.css',['depends' => [\yii\bootstrap\BootstrapAsset::className()]])?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        @media (min-width: 768px) {
            .sidebar-fixed {
                position: -webkit-fixed;
                position: fixed;
                top: 70;
                left: 0;        
            }
        }

        @media (max-width: 767.98px) {
            .sidebar-toggle-fixed {
                position: fixed;
                top: 10px;
                right: 100px;
                z-index: 1050; /* Ensure it's on top */
            }
        }
    </style>
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
        <div class="row">
            <?php if (MenuHelper::isSideBar()): ?>
            <aside id="sidebar" class="col-md-3 sidebar-fixed d-none d-md-block">
                <?php if (MenuHelper::sideBar('rbac')): ?>
                    <?= $this->render('_rbac_sidebar',['asideTitle' => 'Control de acceso']) ?>
                <?php elseif (MenuHelper::sideBar('usuarios')): ?>
                    <?= $this->render('_usuarios_sidebar',['asideTitle' => 'Gestión de usuarios']) ?>
                <?php elseif (MenuHelper::sideBar('materiales')): ?>
                    <?= $this->render('_materiales_sidebar',['asideTitle' => 'Gestión de contenido']) ?>
                <?php endif; ?>
            </aside>
            <div class="col-md-2"></div>
            <div class="col-md-10">
                <?php if (MenuHelper::sideBar('rbac') || MenuHelper::sideBar('usuarios') || MenuHelper::sideBar('materiales')): ?>
                    <!-- Toggle Button for Small Screens -->
                    <button class="btn btn-dark sidebar-toggle-fixed d-md-none like-nav-colors" type="button" data-toggle="collapse" data-target="#sidebar-collapsed" aria-expanded="false" aria-controls="sidebar-collapsed">
                        Gestión
                    </button>
                    <div id="sidebar-collapsed" class="collapse d-md-none">
                        <?php if (MenuHelper::sideBar('rbac')): ?>
                            <?= $this->render('_rbac_sidebar') ?>
                        <?php elseif (MenuHelper::sideBar('usuarios')): ?>
                            <?= $this->render('_usuarios_sidebar') ?>
                        <?php elseif (MenuHelper::sideBar('materiales')): ?>
                            <?= $this->render('_materiales_sidebar') ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?= $content ?>
            </div>
            <?php else: ?>
            <div class="col-md-12">
                <?= $content ?>
            </div>
            <?php endif; ?>
        </div>
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
