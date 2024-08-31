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
}
