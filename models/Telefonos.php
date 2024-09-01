<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "telefonos".
 *
 * @property int $id
 * @property int|null $usuario
 * @property string|null $telefono
 *
 * @property Usuarios $usuario0
 */
class Telefonos extends \yii\db\ActiveRecord
{
    public $username;
    public $email;
    public $nombre_apellidos;
    public $pais;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'telefonos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario'], 'integer'],
            [['usuario', 'telefono'], 'unique', 'targetAttribute' => ['usuario', 'telefono']],
            [['usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['usuario' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario' => 'Usuario',
            'telefono' => 'Telefono',
        ];
    }

    /**
     * Gets query for [[Usuario0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'usuario']);
    }
    
    public function GetUsuarioAttribute($attribute) {
        return implode('',$this->getUsuario()->select($attribute)->column());
    }
    
    public static function getUserOptions()
    {
        return Usuarios::find()
            ->select(['CONCAT(nombre_apellidos, " (", email, ")") AS name'])
            ->column();
    }
    
    public function getUserPhones($userId)
    {
        return self::find()->where(['usuario' => $userId])->all();
    }
}
