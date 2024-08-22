<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;

    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xls, xlsx'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $filePath = 'uploads/' . $this->file->baseName . '.' . $this->file->extension;
            $this->file->saveAs($filePath);
            return $filePath;
        } else {
            return false;
        }
    }
}
