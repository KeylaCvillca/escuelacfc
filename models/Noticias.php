<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "noticias".
 *
 * @property int $id
 * @property string|null $fecha_publicacion
 * @property string|null $contenido
 * @property int|null $autor
 *
 * @property Usuarios $id0
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
            [['fecha_publicacion'], 'safe'],
            [['autor'], 'integer'],
            [['contenido'], 'string', 'max' => 3000],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha_publicacion' => 'Fecha Publicacion',
            'contenido' => 'Contenido',
            'autor' => 'Autor',
        ];
    }

    /**
     * Gets query for [[Id0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'id']);
    }
}
