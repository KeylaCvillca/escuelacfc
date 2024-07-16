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
                    ['label' => 'About', 'url' => ['/site/about']],
                    ['label' => 'Contact', 'url' => ['/site/contact']],
                    ['label' => 'Login', 'url' => ['/site/login']]    
                    ];
            case "alumna":
                return [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    ['label' => 'Soy una alumna', 'url' => ['/site/index']],
                    ['label' => 'About', 'url' => ['/site/about']],
                    ['label' => 'Contact', 'url' => ['/site/contact']],
                    '<li>' . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
                        . Html::submitButton('Logout (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'btn btn-link logout']) . Html::endForm(). '</li>'    
                    ];
            case "maestra":
                return [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    ['label' => 'Soy una maestra', 'url' => ['/site/index']],
                    ['label' => 'About', 'url' => ['/site/about']],
                    ['label' => 'Contact', 'url' => ['/site/contact']],
                    '<li>' . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
                        . Html::submitButton('Logout (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'btn btn-link logout']) . Html::endForm(). '</li>'    
                    ];
            case "admin":
                return [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    ['label' => 'Soy un administrador', 'url' => ['/site/index']],
                    ['label' => 'About', 'url' => ['/site/about']],
                    ['label' => 'Contact', 'url' => ['/site/contact']],
                    '<li>' . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
                        . Html::submitButton('Logout (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'btn btn-link logout']) . Html::endForm(). '</li>'    
                    ];
            
            }
        }
    
    public static function navMenu() {
        return Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => Yii::$app->user->identity == null?
                MenuHelper::links("guest")
                :MenuHelper::links(Yii::$app->user->getRole())
        ]);
    }
    
}

