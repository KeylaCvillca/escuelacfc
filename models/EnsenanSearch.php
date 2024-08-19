<?php
namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class EnsenanSearch extends Ensenan
{
    public function rules()
    {
        return [
            [['maestra', 'color'], 'integer'],
            [['funcion'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Ensenan::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['maestra' => $this->maestra])
              ->andFilterWhere(['color' => $this->color])
              ->andFilterWhere(['like', 'funcion', $this->funcion]);

        return $dataProvider;
    }
}

