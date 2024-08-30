<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "noticias".
 *
 * @property int $id
 * @property string $titulo
 * @property string|null $fecha_publicacion
 * @property string|null $contenido
 * @property int|null $autor
 * @property int $publico
 *
 * @property Usuarios $autor
 */
class Noticias extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'noticias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo'], 'required'],
            [['fecha_publicacion'], 'safe'],
            [['autor', 'publico'], 'integer'],
            [['titulo'], 'string', 'max' => 255],
            [['contenido'], 'string', 'max' => 3000],
            [['autor'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['autor' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'fecha_publicacion' => 'Fecha Publicacion',
            'contenido' => 'Contenido',
            'autor' => 'Autor',
            'publico' => 'Publico',
        ];
    }

    /**
    * Gets query for [[Autor]].
    *
    * @return \yii\db\ActiveQuery
    */
   public function getAutor()
   {
       return $this->hasOne(Usuarios::class, ['id' => 'autor']);
   }

    /**
     * Devuelve el nombre y apellidos del autor.
     * 
     * @return string
     */
    public function getAutorNombreApellidos()
    {
        // Usa la relación definida para obtener el autor
        return $this->getAutor()->one() ? $this->getAutor()->one()->nombre_apellidos : 'Desconocido';
    }
    
    public function getFechaFormateada() {
        if ($this->fecha_publicacion) {
            setlocale(LC_TIME, 'es_ES.UTF-8');
            $timestamp = strtotime($this->fecha_publicacion);
            return strftime('%d de %B de %Y', $timestamp);
            }
        return null;
    }
    
}         
