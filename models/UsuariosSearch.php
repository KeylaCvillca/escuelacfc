<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class UsuariosSearch extends Usuarios
{
    public $telefono; // For searching by phone number

    public function rules()
    {
        return [
            [['nombre_apellidos', 'email', 'rol', 'telefono','color'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Usuarios::find();

        // Join with the Telefonos table to allow searching by phone number
        $query->joinWith('telefonos');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'nombre_apellidos', $this->nombre_apellidos])
              ->andFilterWhere(['like', 'email', $this->email])
              ->andFilterWhere(['like', 'rol', $this->rol])
                ->andFilterWhere(['like', 'color', $this->color])
              ->andFilterWhere(['like', 'telefonos.telefono', $this->telefono]);

        return $dataProvider;
    }
}

