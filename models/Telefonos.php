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
            [['telefono'], 'string', 'max' => 20],
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
    public function getUsuario0()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'usuario']);
    }
}
