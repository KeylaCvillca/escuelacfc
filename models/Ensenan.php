<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ensenan".
 *
 * @property int $id
 * @property int|null $maestra
 * @property string|null $color
 * @property string|null $funcion
 *
 * @property Niveles $color0
 * @property Usuarios $maestra0
 */
class Ensenan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ensenan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['maestra'], 'integer'],
            [['color'], 'string', 'max' => 15],
            [['funcion'], 'string', 'max' => 20],
            [['maestra', 'color'], 'unique', 'targetAttribute' => ['maestra', 'color']],
            [['color'], 'exist', 'skipOnError' => true, 'targetClass' => Niveles::class, 'targetAttribute' => ['color' => 'color']],
            [['maestra'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['maestra' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'maestra' => 'Maestra',
            'color' => 'Color',
            'funcion' => 'Funcion',
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
     * Gets query for [[Maestra0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMaestra0()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'maestra']);
    }
}
