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
        $query = Utilizan::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['nombre_instrumento'] = [
            'asc' => ['instrumentos.nombre' => SORT_ASC],
            'desc' => ['instrumentos.nombre' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['nombre_paso'] = [
            'asc' => ['pasos.nombre' => SORT_ASC],
            'desc' => ['pasos.nombre' => SORT_DESC],
        ];
        
        
        // Cargar los parámetros de búsqueda
        $this->load($params);

        if (!$this->validate()) {
            // si la validación falla, no devolver resultados
            return $dataProvider;
        }

        // Filtrar por ID, video
        $query->andFilterWhere([
            'id' => $this->id,
            'instrumento' => $this->instrumento,
            'paso' => $this->paso,
        ]);

        // Búsqueda por nombre del instrumento (convertir a ID)
        if ($this->nombre_instrumento) {
            $query->joinWith(['instrumento' => function($q) {
                $q->where(['instrumentos.id' => $this->nombre_instrumento]);
            }]);
        }

        // Búsqueda por nombre del paso (convertir a ID)
        if ($this->nombre_paso) {
            $query->joinWith(['paso' => function($q) {
                $q->where(['pasos.id' => $this->nombre_paso]);
            }]);
        }

        // Búsqueda por nombre del video
        $query->andFilterWhere(['like', 'video', $this->video]);

        return $dataProvider;
    }
}
