<?php

namespace app\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "pasos".
 *
 * @property int $id
 * @property string|null $cita_biblica
 * @property string|null $nombre
 * @property string|null $descripcion
 * @property string|null $imagen
 * @property string|null $color
 *
 * @property Niveles $color0
 * @property Instrumentos[] $Instrumentos
 * @property Utilizan[] $utilizans
 */
class Pasos extends \yii\db\ActiveRecord
{
    public $imagenFile;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pasos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cita_biblica', 'imagen'], 'string', 'max' => 50],
            [['nombre'], 'string', 'max' => 30],
            [['descripcion'], 'string', 'max' => 3000],
            [['color'], 'string', 'max' => 15],
            [['color'], 'exist', 'skipOnError' => true, 'targetClass' => Niveles::class, 'targetAttribute' => ['color' => 'color']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cita_biblica' => 'Cita Bíblica',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'imagen' => 'Imagen',
            'color' => 'Color',
        ];
    }

    /**
     * Gets query for [[Color0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getColor0()
    {
        return $this->hasOne(Niveles::class, ['color' => 'color']);
    }

    /**
     * Gets query for [[Instrumentos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInstrumentos()
    {
        return $this->hasMany(Instrumentos::class, ['id' => 'instrumento'])->viaTable('utilizan', ['paso' => 'id']);
    }

    /**
     * Gets query for [[Utilizans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUtilizans()
    {
        return $this->hasMany(Utilizan::class, ['paso' => 'id']);
    }
    
    public function getImgUrl() {
        $imgPath = Yii::getAlias('@webroot/imagenes/pasos/' . $this->imagen);
        
        return Url::to((file_exists($imgPath)? '@web/imagenes/pasos/' . $this->imagen:"@web/imagenes/pasos/default.jpg"));
    }
    
    /**
     * Devuelve una cadena con los nombres de los instrumentos utilizados en este paso, separados por comas.
     * 
     * @return string Los nombres de los instrumentos separados por comas.
     */
    public function getInstrumentosNombres()
    {
        // Obtén todos los nombres de los instrumentos asociados a este paso
        $instrumentos = $this->getInstrumentos()->select('nombre')->column();

        // Une los nombres de los instrumentos con comas
        return implode(', ', $instrumentos);
    }
    
    public function uploadImage()
    {
        if ($this->validate()) {
        // Genera un nombre de archivo único basado en el nombre del paso y la extensión del archivo
        $fileName = strtolower($this->nombre) . '.' . $this->imagenFile->extension;
        $filePath = Yii::getAlias('@webroot/imagenes/pasos/') . $fileName;
        
        if ($this->imagenFile->saveAs($filePath)) {
            // Asigna el nombre del archivo al atributo 'imagen'
            $this->imagen = $fileName;
            return true;
        }
    }
    return false;
    }
}
