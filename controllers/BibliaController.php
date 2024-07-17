<?php

namespace app\controllers;


use app\assets\biblia\Biblia;
use yii\base\Controller;
use app\models\ConsultaBiblica;
use Yii;

class BibliaController extends Controller {
     public static function getText($vers)
     {
         return Biblia::getVersiculo($vers);
     }
    
    // public static function getVersiculos($string) {
        
    // }
    
    // public static function getVersiculoAleatorio() {
        
    // }
     
    public function actionBuscar($quote) {
        return $this->render('search', [
            'text' => Biblia::getVersiculo($quote)
        ]);
    }
    
    public function actionSearch() {
        $model = new ConsultaBiblica();
        $text = null;

        if ($model->load(Yii::$app->request->get()) && $model->validate()) {
            $text = Biblia::getVersiculo($model->quote);
        }

        return $this->render('search', [
            'model' => $model,
            'text' => $text
        ]);
    }
    
    public function actionIndex() {
        return $this->render('index', [
            'verse' => Biblia::getVersiculo("Juan 3:16"),
            'indice' => Biblia::getIndex()
        ]);
    }
    
    
}
