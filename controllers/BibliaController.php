<?php

namespace app\controllers;


use app\assets\biblia\Biblia;
use yii\base\Controller;

class BibliaController extends Controller {
     public static function getVersiculo($vers)
     {
         return Biblia::getVersiculo($vers);
     }
    
    // public static function getVersiculos($string) {
        
    // }
    
    // public static function getVersiculoAleatorio() {
        
    // }
    
    public function actionIndex() {
        return $this->render('index', []);
    }
    
    
}
