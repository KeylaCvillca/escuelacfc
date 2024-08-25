<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

class UploadExcelForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;

    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xls, xlsx', 'checkExtensionByMimeType' => false],
        ];
    }

    public function upload()
    {
        Yii::debug(Yii::getAlias('@webroot') . '/excel/' . $this->file->baseName . '.' . $this->file->extension);
        if ($this->validate()) {
            Yii::debug("Validado");
            $path = Yii::getAlias('@webroot') . '/excel/' . $this->file->baseName . '.' . $this->file->extension;
            return $this->file->saveAs($path);
        } else {
            Yii::debug('Validation failed. Errors: ' . json_encode($this->getErrors()));
            return false;
        }
    }
    
    public function getPath() {
        return Yii::getAlias('@webroot') . '/excel/' . $this->file->baseName . '.' . $this->file->extension;
    }
}
