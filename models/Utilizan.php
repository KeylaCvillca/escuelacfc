<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "utilizan".
 *
 * @property int $id
 * @property int|null $instrumento
 * @property int|null $paso
 * @property string|null $video
 *
 * @property Instrumentos $instrumento0
 * @property Pasos $paso0
 */
class Utilizan extends \yii\db\ActiveRecord
{
    public $file; // Propiedad para manejar la subida de archivos
    public $nombre_instrumento;
    public $nombre_paso;
    public $nombre_video;
    
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilizan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['instrumento', 'paso'], 'integer'],
            [['video'], 'string', 'max' => 50],
            [['instrumento', 'paso'], 'unique', 'targetAttribute' => ['instrumento', 'paso']],
            [['instrumento'], 'exist', 'skipOnError' => true, 'targetClass' => Instrumentos::class, 'targetAttribute' => ['instrumento' => 'id']],
            [['paso'], 'exist', 'skipOnError' => true, 'targetClass' => Pasos::class, 'targetAttribute' => ['paso' => 'id']],
            [['file'], 'file', 'extensions' => 'mp4, avi, mkv, mov, webm', 'maxSize' => 1024 * 1024 * 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'instrumento' => 'Instrumento',
            'paso' => 'Paso',
            'video' => 'Video',
        ];
    }

    /**
     * Gets query for [[Instrumento0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInstrumento()
    {
        return $this->hasOne(Instrumentos::class, ['id' => 'instrumento']);
    }

    /**
     * Gets query for [[Paso0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaso()
    {
        return $this->hasOne(Pasos::class, ['id' => 'paso']);
    }
    
    public function upload()
    {
        if ($this->validate()) {
            $this->file->saveAs('videos/pasos/' . $this->file->baseName . '.' . $this->file->extension);
            return true;
        } else {
            return false;
        }
    }
    
    public function getNombreInstrumento()
    {
        // Obtén todos los nombres de los instrumentos asociados a este paso
        return implode('',$this->getInstrumento()->select('nombre')->column());
    }
    
    public function getNombrePaso()
    {
        // Obtén todos los nombres de los instrumentos asociados a este paso
        return implode('',$this->getPaso()->select('nombre')->column());
    }
}
