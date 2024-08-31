<?php

namespace app\models;

use yii\base\Model;

class File extends Model
{
    public $name;
    public $extension;
    public $path;

    public function rules()
    {
        return [
            [['name', 'extension', 'path'], 'required'],
            [['name', 'extension', 'path'], 'string'],
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
                $path = $fileinfo->getRealPath();
                $name = basename($path);
                $extension = pathinfo($path, PATHINFO_EXTENSION);

                $files[] = new self([
                    'name' => $name,
                    'extension' => $extension,
                    'path' => str_replace(\Yii::getAlias('@webroot'), '', $path),
                ]);
            }
        }

        return $files;
    }
}
