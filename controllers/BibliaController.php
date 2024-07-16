<?php

namespace app\controllers;


use app\assets\biblia\Biblia;
use yii\base\Controller;

class BibliaController extends Controller {
     public static function getText($vers)
     {
         return Biblia::getVersiculo($vers);
     }
    
    // public static function getVersiculos($string) {
        
    // }
    
    // public static function getVersiculoAleatorio() {
        
    // }
     
    public function actionSearch($quote) {
        return $this->render('search', [
            'text' => Biblia::getVersiculo($quote)
        ]);
    }
    
    public function actionIndex() {
        return $this->render('index', [
            'verse' => Biblia::getVersiculo("Juan 3:16"),
            'indice' => Biblia::getIndex()
        ]);
    }
    
    
}
