<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadExcelForm extends Model
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
            $path = Yii::getAlias('@webroot') . '/excel/' . $this->file->baseName . '.' . $this->file->extension;
            return $this->file->saveAs($path);
        } else {
            return false;
        }
    }
}
