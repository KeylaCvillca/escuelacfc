<?php
namespace app\assets\biblia;

use yii\helpers\Json;
use Yii;
/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

 class Biblia  {
     
     private static $VOCALS = array(
        'á' => 'a',
        'é' => 'e',
        'í' => 'i',
        'ó' => 'o',
        'ú' => 'u',
        'Á' => 'A',
        'É' => 'E',
        'Í' => 'I',
        'Ó' => 'O',
        'Ú' => 'U'
    );
     public static function getVersiculo($vers)
     {
         $i = self::findSeparator($vers);
         $libro= self::parseBookName(substr($vers, 0, $i));
         $partes = explode(":", substr($vers,$i+1)); //partes{0}capitulo y partes{1}versiculo
         
         $data = self::read($libro);
         return (strpos($partes[1],"-") !== false)?Biblia::findVersiculos($partes,$data):Biblia::findVersiculo($partes, $data);
     }
    
    /** Devuelve un array asociativo leyendo el archivo _index.json
     */
    public static function getIndex() {
        return self::read("index.json");
   }
    
      
     /*private static function read($libro) {
         return Json::decode(file_get_contents("c:\\xampp\\htdocs\\danzacfc\\biblia\\" . $libro));
     }*/
     private static function read($libro) {
        // Ajusta esta ruta para que sea relativa al directorio de "danzacfc"
        $path = realpath(__DIR__ ."/". $libro);
        return Json::decode(file_get_contents($path));
    }
     private static function findVersiculo($partes, $data) {
        
         
         if ($partes[0] < 1 || $partes[0] > count($data)) {
            return "Este capítulo no existe.";
        } else if ( $partes[1] < 1 || $partes[1] - 1 >= count($data[$partes[0] - 1])) {
            return "Este versículo no existe.";
        } else {
        
        //echo count($data[0]);            
        return $data[$partes[0] - 1][$partes[1] - 1];
        } 
     }
     
     private static function findVersiculos($partes, $data) {
         $versiculos = explode("-",$partes[1]);
         $temp = "";
         for($i = $versiculos[0]; $i <= $versiculos[1]; $i++) {
            $temp .= Biblia::findVersiculo([$partes[0],$i],$data);
         }
         return $temp;
     }
   
     private static function parseBookName($name) {
        return strtr(strtolower(str_replace(" ", "_", $name)), self::$VOCALS) . ".json";
    }

    
     private static function findSeparator($string) {
         $i = strlen($string)-1; 
         while ($string[$i]!=" "){
             $i--;}
         return $i;
     }
 }

