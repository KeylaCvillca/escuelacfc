<?php

namespace app\assets\biblia;

use yii\helpers\Json;
use Yii;

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
        if ($i == -1) {
            return "No se ha podido procesar el versículo";
        }

        $libro = self::parseBookName(substr($vers, 0, $i));
        $partes = explode(":", substr($vers, $i + 1)); //partes{0} capítulo y partes{1} versículo
        
        try {
            $data = self::read($libro);

            $result = (strpos($partes[1], "-") !== false) 
                ? self::findVersiculos($libro, $partes, $data) 
                : self::findVersiculo($libro, $partes, $data);

            // Remove underscores and convert newlines to <br>
            $result = str_replace('_', '', $result); 
            $result = str_replace('/n','',$result);

            return $result;     
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    
    public static function getIndex() {
        return self::read("index.json");
    }
    
    private static function read($libro) {
        try {
            $path = realpath(__DIR__ . "/" . $libro);
            if ($path === false || !file_exists($path)) {
                throw new \Exception("Error, el libro $libro no existe o no se encuentra el archivo.");
            }
            return Json::decode(file_get_contents($path));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    private static function findVersiculo($libro, $partes, $data) {
        if ($partes[0] < 1 || $partes[0] > count($data)) {
            throw new \Exception("Error, capítulo no encontrado en $libro: este libro sólo tiene " . count($data) . " capítulos.");
        } else if ($partes[1] < 1 || $partes[1] - 1 >= count($data[$partes[0] - 1])) {
            throw new \Exception("Error, versículo no encontrado en $libro $partes[0]: este capítulo sólo tiene " . count($data[$partes[0] - 1]) . " versículos.");
        } else {
            return $data[$partes[0] - 1][$partes[1] - 1];
        } 
    }
     
    private static function findVersiculos($libro, $partes, $data) {
        $versiculos = explode("-", $partes[1]);
        $temp = "";
        for ($i = $versiculos[0]; $i <= $versiculos[1]; $i++) {
            $temp .= self::findVersiculo($libro, [$partes[0], $i], $data);
        }
        return $temp;
    }

    private static function parseBookName($name) {
        $name = mb_convert_encoding($name, 'UTF-8', mb_detect_encoding($name));
        $name = strtr($name, self::$VOCALS);
        $name = strtolower(str_replace(" ", "_", $name));

        Yii::debug("Parsed book name: $name");

        return $name . ".json";
    }

    private static function findSeparator($string) {
        $i = strlen($string) - 1;
        Yii::debug($i . $string);
        while ($i >= 0 && $string[$i] != " ") {
            $i--;
        }
        return ($i < 0) ? -1 : $i;
    }
}
