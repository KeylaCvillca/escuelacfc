<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Instrumentos".
 *
 * @property int $id
 * @property string|null $nombre
 * @property string|null $significado
 * @property string|null $cita_biblica
 *
 * @property Pasos[] $pasos
 * @property Utilizan[] $utilizans
 */
class Instrumentos extends \yii\db\ActiveRecord
{
    public $imagenFile;
    public $texto;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Instrumentos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'string', 'max' => 20],
            [['significado'], 'string', 'max' => 3000],
            [['cita_biblica'], 'string', 'max' => 50],
            [['imagenFile'], 'file', 'extensions' => 'jpg', 'checkExtensionByMimeType' => true],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'significado' => 'Significado',
            'cita_biblica' => 'Cita Biblica',
        ];
    }

    /**
     * Gets query for [[Pasos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPasos()
    {
        return $this->hasMany(Pasos::class, ['id' => 'paso'])->viaTable('utilizan', ['instrumento' => 'id']);
    }

    /**
     * Gets query for [[Utilizans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUtilizans()
    {
        return $this->hasMany(Utilizan::class, ['instrumento' => 'id']);
    }
    
    public function uploadImage()
    {
        if ($this->validate()) {
            $fileName = strtolower($this->nombre) . '.' . $this->imagenFile->extension;
            $filePath = Yii::getAlias('@webroot/imagenes/instrumentos/') . $fileName;
            if ($this->imagenFile->saveAs($filePath)) {
                return true;
            }
        }
        return false;
    }
}
