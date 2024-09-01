<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Utilizan;

class UtilizanSearch extends Utilizan
{
    public $nombre_instrumento;
    public $nombre_paso;

    public function rules()
    {
        return [
            [['id', 'instrumento', 'paso'], 'integer'],
            [['video', 'nombre_instrumento', 'nombre_paso'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Utilizan::find()
            ->joinWith('instrumento') // Unir con la tabla instrumentos
            ->joinWith('paso'); // Unir con la tabla pasos

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'nombre_instrumento' => [
                        'asc' => ['instrumentos.nombre' => SORT_ASC],
                        'desc' => ['instrumentos.nombre' => SORT_DESC],
                    ],
                    'nombre_paso' => [
                        'asc' => ['pasos.nombre' => SORT_ASC],
                        'desc' => ['pasos.nombre' => SORT_DESC],
                    ],
                    'video',
                ],
            ],
        ]);

        // Cargar los parámetros de búsqueda
        $this->load($params);

        if (!$this->validate()) {
            // si la validación falla, no devolver resultados
            return $dataProvider;
        }

        // Filtrar por ID, video
        $query->andFilterWhere([
            'utilizan.id' => $this->id,
            'utilizan.instrumento' => $this->instrumento,
            'utilizan.paso' => $this->paso,
        ]);

        // Búsqueda por nombre del instrumento (convertir a ID)
        if ($this->nombre_instrumento) {
            $query->andFilterWhere(['instrumentos.nombre' => $this->nombre_instrumento]);
        }

        // Búsqueda por nombre del paso (convertir a ID)
        if ($this->nombre_paso) {
            $query->andFilterWhere(['pasos.nombre' => $this->nombre_paso]);
        }

        // Búsqueda por nombre del video
        $query->andFilterWhere(['like', 'video', $this->video]);

        return $dataProvider;
    }
}
