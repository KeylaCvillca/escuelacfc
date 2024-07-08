<?php
namespace app\assets\biblia;

use yii\helpers\Json;
/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

 class Biblia  {
     public static function getVersiculo($vers)
     {
         $i = Biblia::findSeparator($vers);
         $libro= Biblia::parseBookName(substr($vers, 0, $i));
         $partes = explode(":", substr($vers,$i+1)); //partes{0}capitulo y partes{1}versiculo
         $data = Biblia::read($libro);
         return Biblia::findVersiculo($partes, $data);
     }
    
    /** Devuelve un array asociativo leyendo el archivo _index.json
     */
    public static function getIndex() {
        
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
         } else if ( $partes[1] < 1 || $partes[1] - 1 > count($data[$partes[0]])) {
             return "Este versículo no existe.";
         } else {

 //echo count($data[0]);            
 return $data[$partes[0] - 1][$partes[1] - 1];
         } 
     }
   
     private static function parseBookName($name) {
         return strtolower(str_replace(" ","_",$name)) . ".json";
     }
    
     private static function findSeparator($string) {
         $i = strlen($string)-1; 
         while ($string[$i]!=" "){$i--;}
         return $i;
     }
 }

