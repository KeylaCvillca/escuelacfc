<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
namespace app\assets;

use yii\helpers\Html;
use yii\bootstrap4\Nav;
use Yii;

class MenuHelper {
    private const SIDEBAR = [
        'rbac' => [
            'controllers' => ['route','permission', 'role', 'assignment', 'rule'],
            'permisos' => ['admin'],
            'asideTitle' => 'Control de acceso'
        ],
        'usuarios' => [
            'controllers' => ['usuarios','ensenan', 'telefonos'],
            'permisos' => ['admin'],
            'asideTitle' => 'Gestión de usuarios'
        ],
        'materiales' => [
            'controllers' => ['pasos','instrumentos', 'niveles', 'utilizan','noticias','file'],
            'permisos' => ['admin','maestra'],
            'asideTitle' => 'Gestión de contenido'
        ]
    ];
    
    private static function links($role) {
        switch($role) { 
            case "guest":
                return [
                    ['label' => 'Home', 'url' => ['/site/index#inicio']],
                    ['label' => 'Conócenos', 'url' => ['/site/index#about']],
                    ['label' => 'Noticias', 'url' => ['/site/index#noticias']],
                    ['label' => 'Contacto', 'url' => ['/site/index#contact']],
                    ['label' => 'Conectarse', 'url' => ['/site/login']]    
                    ];
            case "alumna":
                return [
                    ['label' => 'Home', 'url' => ['/site/index'],
                        'options' => ['style' => (self::checkRoute('site/index'))?self::underlineStyle():'']],      
                    ['label' => 'Materiales', 'url' => ['/pasos/index'],
                        'options' => ['style' => (self::checkController('materiales') &&
                                Yii::$app->controller->action->id != "quiz"&&
                                Yii::$app->controller->action->id != "misnoticias" &&
                                Yii::$app->controller->action->id != "read")?self::underlineStyle():'']],
                    ['label' => 'Conócenos', 'url' => ['/site/index#conocenos'],
                        'options' => ['style' => (self::checkRoute('site/index'))?self::underlineStyle():'']],
                    ['label' => 'Quiz', 'url' => ['/pasos/quiz'],
                        'options' => ['style' => (self::checkRoute('pasos/quiz'))?self::underlineStyle():'']],
                    ['label' => 'Mis noticias', 'url' => ['/noticias/misnoticias'],
                        'options' => ['style' => (self::checkRoute('noticias/misnoticias'))?self::underlineStyle():'']],
                    ['label' => 'Alumna(' . Yii::$app->user->identity->username . ')', 'url' => ['/usuarios/misdatos'],
                        'options' => ['style' => (self::checkRoute('usuarios/misdatos'))?self::underlineStyle():'']],
                    '<li>' . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
                        . Html::submitButton('Salir',
                        ['class' => 'btn btn-link logout']) . Html::endForm(). '</li>'    
                    ];
            case "maestra":
                return [
                    ['label' => 'Home', 'url' => ['/site/index'],
                        'options' => ['style' => (self::checkRoute('site/index'))?self::underlineStyle():'']],
                    ['label' => 'Materiales', 'url' => ['/pasos/index'],
                        'options' => ['style' => (self::checkController('materiales') &&
                                Yii::$app->controller->action->id != "quiz"&&
                                Yii::$app->controller->action->id != "misnoticias" &&
                                Yii::$app->controller->action->id != "read")?self::underlineStyle():'']],
                    ['label' => 'Mis alumnas', 'url' => ['/usuarios/alumnas'],
                        'options' => ['style' => (self::checkRoute('usuarios/alumnas'))?self::underlineStyle():'']],
                    ['label' => 'Quiz', 'url' => ['/pasos/quiz'],
                        'options' => ['style' => (self::checkRoute('pasos/quiz'))?self::underlineStyle():'']],
                    ['label' => 'Mis noticias', 'url' => ['/noticias/misnoticias'],
                        'options' => ['style' => (self::checkRoute('noticias/misnoticias'))?self::underlineStyle():'']],
                    ['label' => 'Noticias', 'url' => ['/noticias/read'],
                        'options' => ['style' => (self::checkRoute('noticias/read'))?self::underlineStyle():'']],
                    ['label' => 'Maestra(' . Yii::$app->user->identity->username . ')', 'url' => ['/usuarios/misdatos'],
                        'options' => ['style' => (self::checkRoute('usuarios/misdatos'))?self::underlineStyle():'']],
                    '<li>' . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
                        . Html::submitButton('Salir',
                        ['class' => 'btn btn-link logout']) . Html::endForm(). '</li>'    
                    ];
            case "admin":
                return [
                    ['label' => 'Home', 'url' => ['/site/index'],
                        'options' => ['style' => (self::checkRoute('site/index'))?self::underlineStyle():'']],
                    ['label' => 'Acceso','url'=>['/rbac/route'],
                        'options' => ['style' => (self::checkController('rbac'))?self::underlineStyle():'']],
                    ['label'=> 'Usuarios','url'=>['/usuarios/index'],
                        'options' => ['style' => (self::checkController('usuarios')
                                && Yii::$app->controller->action->id != 'misdatos')?self::underlineStyle():'']],
                    ['label'=> 'Contenido','url'=>['/file/index'],
                        'options' => ['style' => (self::checkController('materiales') &&
                                Yii::$app->controller->action->id != "quiz")?self::underlineStyle():'']],
                    ['label' => 'Quiz', 'url' => ['/pasos/quiz'],
                        'options' => ['style' => (self::checkRoute('pasos/quiz'))?self::underlineStyle():'']],
                    ['label' => 'Administrador (' . Yii::$app->user->identity->username . ')', 'url' => ['/usuarios/misdatos'],
                        'options' => ['style' => (self::checkRoute('usuarios/misdatos'))?self::underlineStyle():'']],
                    '<li>' . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
                        . Html::submitButton('Salir',
                        ['class' => 'btn btn-link logout']) . Html::endForm(). '</li>'    
                    ];
            }
        }
    
    public static function isSideBar() {
        if (Yii::$app->user->isGuest) {
            return false;
        }
        foreach(self::SIDEBAR as $section => $data) {
            if ((in_array(Yii::$app->controller->id, self::SIDEBAR[$section]['controllers']))    
                && in_array(Yii::$app->user->identity->getRole(), self::SIDEBAR[$section]['permisos']))
                return true;
        }
        return false;
    }    
        
    public static function sideBar($section) {
        if (!array_key_exists($section, self::SIDEBAR)) {
            return false;
        }
        if (!in_array(Yii::$app->controller->id, self::SIDEBAR[$section]['controllers'])) {
            return false;
        }
        return self::canIn(self::SIDEBAR[$section]['permisos']);
    }
    
    public static function navMenu() {
        return Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => Yii::$app->user->identity == null?
                MenuHelper::links("guest")
                :MenuHelper::links(Yii::$app->user->identity->getRole())
        ]);
    }
    
    public static function canIn($roles) {
        foreach ($roles as $rol) {
            if (Yii::$app->user->can($rol)) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Retrieve the asideTitle based on the controller name.
     *
     * @param string $controllerName The controller name to search for.
     * @return string|null The asideTitle if found, null otherwise.
     */
    public static function sideBarTitle($controllerName)
    {
        foreach (self::SIDEBAR as $key => $info) {
            if (in_array($controllerName, $info['controllers'])) {
                return $info['asideTitle'];
            }
        }
        return ''; // Return null if the controller is not found
    }
    
    private static function checkController($section) {
        return in_array(Yii::$app->controller->id, self::SIDEBAR[$section]['controllers']);
    }
    
    private static function checkRoute($route) {
        return Yii::$app->controller->id . '/' . Yii::$app->controller->action->id === $route;
    }
    
    private static function underlineStyle() {
        return 'color: var(--color-hover-texto) !important;
                                 border-bottom: 2px solid var(--color-hover-borde) !important;
                                 text-align:center';
    }
    
}

