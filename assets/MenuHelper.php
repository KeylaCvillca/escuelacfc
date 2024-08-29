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
    const SECTIONS = [
      'rbac' => ['route','permission', 'role', 'assignment', 'rule'],
      'usuarios' => ['usuarios','ensenan', 'telefonos'],
      'materiales' => ['pasos','instrumentos', 'niveles', 'utilizan','noticias'],
    ];
    
    private static function links($role) {
        switch($role) { 
            case "guest":
                return [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    ['label' => 'Conócenos', 'url' => ['/site/about']],
                    ['label' => 'Noticias', 'url' => ['/noticias/public']],
                    ['label' => 'Contacto', 'url' => ['/site/contact']],
                    ['label' => 'Conectarse', 'url' => ['/site/login']]    
                    ];
            case "alumna":
                return [
                    ['label' => 'Home', 'url' => ['/site/index']],      
                    ['label' => 'Materiales', 'url' => ['/pasos/index']],
                    ['label' => 'Conócenos', 'url' => ['/site/about']],
                    ['label' => 'Quiz', 'url' => ['/pasos/quiz']],
                    ['label' => 'Noticias', 'url' => ['/noticias/read']],
                    ['label' => 'Alumna (' . Yii::$app->user->identity->username . ')', 'url' => ['/usuarios/misdatos']],
                    '<li>' . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
                        . Html::submitButton('Salir',
                        ['class' => 'btn btn-link logout']) . Html::endForm(). '</li>'    
                    ];
            case "maestra":
                return [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    ['label' => 'Materiales', 'url' => ['/pasos/index']],
                    ['label' => 'Mis alumnas', 'url' => ['/usuarios/alumnas']],
                    ['label' => 'Quiz', 'url' => ['/pasos/quiz']],
                    ['label' => 'Publicaciones', 'url' => ['/noticias/misnoticias']],
                    ['label' => 'Noticias', 'url' => ['/noticias/read']],
                    ['label' => 'Maestra (' . Yii::$app->user->identity->username . ')', 'url' => ['/usuarios/misdatos']],
                    '<li>' . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
                        . Html::submitButton('Salir',
                        ['class' => 'btn btn-link logout']) . Html::endForm(). '</li>'    
                    ];
            case "admin":
                return [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    ['label' => 'Administración', 
                        'items' => [
                        ['label' => 'Acceso','url'=>['/rbac/route']],
                        ['label'=> 'Usuarios','url'=>['/usuarios/index']],
                        ['label'=> 'Funciones','url'=>['/ensenan/index']],
                        ['label'=> 'Archivos','url'=>['/site/files']],
                        ['label'=> 'Noticias','url'=>['/noticias/index']],
                    ]],
                    ['label' => 'Materiales', 'url' => ['/pasos/index']],
                    ['label' => 'Quiz', 'url' => ['/pasos/quiz']],
                    ['label' => 'Noticias', 'url' => ['/noticias/read']],
                    ['label' => 'Administrador (' . Yii::$app->user->identity->username . ')', 'url' => ['/usuarios/misdatos']],
                    '<li>' . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
                        . Html::submitButton('Salir',
                        ['class' => 'btn btn-link logout']) . Html::endForm(). '</li>'    
                    ];
            }
        }
    
    public static function sideBar($section) {
        switch($section) {
            case 'rbac':
                return in_array(Yii::$app->controller->id, self::SECTIONS['rbac']) && Yii::$app->user->can('admin');
            case 'usuarios':
                return in_array(Yii::$app->controller->id, self::SECTIONS['usuarios']) && Yii::$app->user->can('admin');
            case 'materiales':
                return in_array(Yii::$app->controller->id, self::SECTIONS['materiales']) && (Yii::$app->user->can('admin') || Yii::$app->user->can('maestra'));
            default:
                return false;
        }
    }
    
    public static function navMenu() {
        return Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => Yii::$app->user->identity == null?
                MenuHelper::links("guest")
                :MenuHelper::links(Yii::$app->user->identity->getRole())
        ]);
    }
    
}

