<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "niveles".
 *
 * @property string $color
 * @property string|null $descripcion
 *
 * @property Ensenan[] $ensenans
 * @property Usuarios[] $maestras
 * @property Pasos[] $pasos
 * @property Usuarios[] $usuarios
 */
class Niveles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'niveles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['color'], 'required'],
            [['color'], 'string', 'max' => 15],
            [['descripcion'], 'string', 'max' => 3000],
            [['color'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'color' => 'Color',
            'descripcion' => 'Descripcion',
        ];
    }

    /**
     * Gets query for [[Ensenans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEnsenans()
    {
        return $this->hasMany(Ensenan::class, ['color' => 'color']);
    }

    /**
     * Gets query for [[Maestras]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMaestras()
    {
        return $this->hasMany(Usuarios::class, ['id' => 'maestra'])->viaTable('ensenan', ['color' => 'color']);
    }

    /**
     * Gets query for [[Pasos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPasos()
    {
        return $this->hasMany(Pasos::class, ['color' => 'color']);
    }

    /**
     * Gets query for [[Usuarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuarios::class, ['color' => 'color']);
    }
}
