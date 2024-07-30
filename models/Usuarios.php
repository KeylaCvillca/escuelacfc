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
 * @property string|null $foto
 * @property string|null $color
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
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
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['nombre_apellidos'], 'string', 'max' => 50],
            [['rol'], 'string', 'max' => 40],
            [['celula'], 'string', 'max' => 20],
            [['foto', 'username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['color'], 'string', 'max' => 15],
            [['auth_key'], 'string', 'max' => 32],
            [['email'], 'unique'],
            [['username'], 'unique'],
            [['password_reset_token'], 'unique'],
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
            'foto' => 'Foto',
            'color' => 'Color',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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

    public function generateAuthKey() {
        
    }

}
