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
    private static function links($role) {
        switch($role) { 
            case "guest":
                return [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    ['label' => 'Soy un invitado', 'url' => ['/site/index']],
                    ['label' => 'Conócenos', 'url' => ['/site/about']],
                    ['label' => 'Contacto', 'url' => ['/site/contact']],
                    ['label' => 'Conectarse', 'url' => ['/site/login']]    
                    ];
            case "alumna":
                return [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    ['label' => 'Conócenos', 'url' => ['/site/about']],
                    ['label' => 'Alumna (' . Yii::$app->user->identity->username . ')', 'url' => ['/usuarios/datos']],
                    ['label' => 'Materiales', 'url' => ['/pasos/index']],
                    ['label' => 'Conócenos', 'url' => ['/site/about']],
                    ['label' => 'Quiz', 'url' => ['/site/quiz']],
                    ['label' => 'Noticias', 'url' => ['/noticias/index']],
                    ['label' => 'Contacto', 'url' => ['/site/contact']],
                    '<li>' . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
                        . Html::submitButton('Salir',
                        ['class' => 'btn btn-link logout']) . Html::endForm(). '</li>'    
                    ];
            case "maestra":
                return [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    ['label' => 'Conócenos', 'url' => ['/site/about']],
                    ['label' => 'Maestra (' . Yii::$app->user->identity->username . ')', 'url' => ['/usuarios/datos']],
                    ['label' => 'Materiales', 'url' => ['/pasos/index']],
                    ['label' => 'Mis alumnas', 'url' => ['/usuarios/alumnas']],
                    ['label' => 'Quiz', 'url' => ['/site/quiz']],
                    ['label' => 'Noticias', 'url' => ['/noticias/index']],
                    ['label' => 'Contacto', 'url' => ['/site/contact']],
                    '<li>' . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
                        . Html::submitButton('Salir',
                        ['class' => 'btn btn-link logout']) . Html::endForm(). '</li>'    
                    ];
            case "admin":
                return [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    ['label' => 'Administración', 
                        'items' => [
                        ['label' => 'Páginas','url'=>['/site/rbac']],
                        ['label'=> 'Usuarios','url'=>['/usuarios/index']],
                        ['label'=> 'Archivos','url'=>['/archivos/index']],
                    ]],
                    ['label' => 'Conócenos', 'url' => ['/site/about']],
                    ['label' => 'Quiz', 'url' => ['/site/quiz']],
                    ['label' => 'Noticias', 'url' => ['/noticias/index']],
                    ['label' => 'Contacto', 'url' => ['/site/contact']],
                    ['label' => 'Administrador (' . Yii::$app->user->identity->username . ')', 'url' => ['/usuarios/datos']],
                    '<li>' . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
                        . Html::submitButton('Salir',
                        ['class' => 'btn btn-link logout']) . Html::endForm(). '</li>'    
                    ];
            
            }
        }
    
    public static function navMenu() {
        return Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => Yii::$app->user->identity == null? // == Null temporal. Ideal: isGuest()
                MenuHelper::links("guest")
                :MenuHelper::links("admin")
        ]);
    }
    
}

