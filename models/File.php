<?php

namespace app\models;

use yii\base\Model;
use Yii;

class File extends Model
{
    private const BASE_DIRECTORY = 'escuelacfc';
    
    public $name;
    public $extension;
    public $path;
    public $realPath;
    public $file;

    public function rules()
    {
        return [
            [['name', 'extension', 'path'], 'required'],
            [['name', 'extension', 'path'], 'string'],
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'jpg, png, gif, mp4, pdf, xls, xlsx, doc, docx'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Nombre',
            'extension' => 'Extensión',
            'path' => 'Ruta',
        ];
    }
    
    /**
     * Encuentra todos los archivos en los directorios especificados.
     *
     * @return array Un array de objetos File
     */
    public static function findAllFiles()
    {
        $directories = [
            \Yii::getAlias('@webroot/imagenes'),
            \Yii::getAlias('@webroot/videos'),
            \Yii::getAlias('@webroot/excel'),
        ];

        $files = [];

        foreach ($directories as $directory) {
            $files = array_merge($files, self::scanDirectory($directory));
        }

        return $files;
    }

    /**
     * Escanea un directorio para encontrar todos los archivos y sus detalles.
     *
     * @param string $directory El directorio para escanear.
     * @return array Un array de objetos File.
     */
    private static function scanDirectory($directory)
    {
        $files = [];
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory));

        foreach ($iterator as $fileinfo) {
            if ($fileinfo->isFile()) {
                $path = self::getPath($fileinfo);
                $name = basename($path);
                $extension = pathinfo($path, PATHINFO_EXTENSION);
                $realPath = $fileinfo->getRealPath();

                $files[] = new self([
                    'name' => $name,
                    'extension' => $extension,
                    'path' => str_replace(\Yii::getAlias('@webroot'), '', $path),
                    'realPath' => $realPath
                ]);
            }
        }

        return $files;
    }
    
    private static function getPath($fileInfo) {
            return explode(self::BASE_DIRECTORY,$fileInfo->getRealPath())[1];
    }
    
    public static function getRealPath($relativePath)
    {
        // Obtener el alias de la raíz de la aplicación
        $webRoot = str_replace("/", "\\", Yii::getAlias('@app'));

        // Reemplazar las barras hacia adelante con barras invertidas en la ruta relativa
        $relativePath = str_replace('/', '\\', $relativePath);

        // Concatenar la raíz de la aplicación con la ruta relativa
        return $webRoot . $relativePath;
    }
    
}
