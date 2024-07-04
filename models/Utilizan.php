<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "utilizan".
 *
 * @property int $id
 * @property int|null $instrumento
 * @property int|null $paso
 * @property string|null $video
 *
 * @property Instrumentos $instrumento0
 * @property Pasos $paso0
 */
class Utilizan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilizan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['instrumento', 'paso'], 'integer'],
            [['video'], 'string', 'max' => 50],
            [['instrumento', 'paso'], 'unique', 'targetAttribute' => ['instrumento', 'paso']],
            [['instrumento'], 'exist', 'skipOnError' => true, 'targetClass' => Instrumentos::class, 'targetAttribute' => ['instrumento' => 'id']],
            [['paso'], 'exist', 'skipOnError' => true, 'targetClass' => Pasos::class, 'targetAttribute' => ['paso' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'instrumento' => 'Instrumento',
            'paso' => 'Paso',
            'video' => 'Video',
        ];
    }

    /**
     * Gets query for [[Instrumento0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInstrumento0()
    {
        return $this->hasOne(Instrumentos::class, ['id' => 'instrumento']);
    }

    /**
     * Gets query for [[Paso0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaso0()
    {
        return $this->hasOne(Pasos::class, ['id' => 'paso']);
    }
}
