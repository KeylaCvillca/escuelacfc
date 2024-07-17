<?php

namespace app\models;

use yii\base\Model;

class ConsultaBiblica extends Model
{
    public $quote;

    public function rules()
    {
        return [
            [['quote'], 'required'],
            [['quote'], 'string', 'max' => 255],
        ];
    }
}
