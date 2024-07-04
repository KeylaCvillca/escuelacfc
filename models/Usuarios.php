<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string|null $nombre_apellidos
 * @property string|null $rol
 * @property string|null $fecha_nacimiento
 * @property string|null $celula
 * @property string|null $fecha_ingreso
 * @property string|null $fecha_graduacion
 * @property string|null $email
 * @property string|null $hash
 * @property string|null $salt
 * @property string|null $foto
 * @property string|null $color
 *
 * @property Niveles $color0
 * @property Niveles[] $colors
 * @property Ensenan[] $ensenans
 * @property Noticias $noticias
 * @property Telefonos[] $telefonos
 */
class Usuarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_nacimiento', 'fecha_ingreso', 'fecha_graduacion'], 'safe'],
            [['nombre_apellidos', 'email'], 'string', 'max' => 50],
            [['rol'], 'string', 'max' => 40],
            [['celula'], 'string', 'max' => 20],
            [['hash', 'foto'], 'string', 'max' => 255],
            [['salt'], 'string', 'max' => 16],
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
            'nombre_apellidos' => 'Nombre Apellidos',
            'rol' => 'Rol',
            'fecha_nacimiento' => 'Fecha Nacimiento',
            'celula' => 'Celula',
            'fecha_ingreso' => 'Fecha Ingreso',
            'fecha_graduacion' => 'Fecha Graduacion',
            'email' => 'Email',
            'hash' => 'Hash',
            'salt' => 'Salt',
            'foto' => 'Foto',
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
     * Gets query for [[Colors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getColors()
    {
        return $this->hasMany(Niveles::class, ['color' => 'color'])->viaTable('ensenan', ['maestra' => 'id']);
    }

    /**
     * Gets query for [[Ensenans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEnsenans()
    {
        return $this->hasMany(Ensenan::class, ['maestra' => 'id']);
    }

    /**
     * Gets query for [[Noticias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNoticias()
    {
        return $this->hasOne(Noticias::class, ['id' => 'id']);
    }

    /**
     * Gets query for [[Telefonos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTelefonos()
    {
        return $this->hasMany(Telefonos::class, ['usuario' => 'id']);
    }
}
