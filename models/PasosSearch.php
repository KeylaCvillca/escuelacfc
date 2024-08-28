<?php
namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class PasosSearch extends Pasos
{
    public function rules()
    {
        return [
            [['nombre', 'color'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Pasos::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
              ->andFilterWhere(['color' => $this->color]);

        return $dataProvider;
    }
}
