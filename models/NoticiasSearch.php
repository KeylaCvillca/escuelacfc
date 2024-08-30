<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * NoticiasSearch represents the model behind the search form of `app\models\Noticias`.
 */
class NoticiasSearch extends Noticias
{
    public $autor_nombre_apellidos; // Atributo para el nombre y apellidos del autor
    public $publico_filtro; // Filtro para la visibilidad de la noticia

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'autor', 'publico'], 'integer'],
            [['titulo', 'contenido', 'fecha_publicacion', 'autor_nombre_apellidos'], 'safe'],
            [['publico_filtro'], 'integer'],
        ];
    }

    /**
     * Creates a data provider instance with search query applied.
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Noticias::find();

        // Join with Usuarios table to filter by author's name and surname
        $query->joinWith('autor'); // Usar la relación correcta

        // Add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // Uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'noticias.id' => $this->id,
            'noticias.autor' => $this->autor,
            'noticias.publico' => $this->publico_filtro,
        ]);

        $query->andFilterWhere(['like', 'noticias.titulo', $this->titulo])
              ->andFilterWhere(['like', 'noticias.contenido', $this->contenido])
              ->andFilterWhere(['like', 'noticias.fecha_publicacion', $this->fecha_publicacion]);

        // Filter by author's name and surname
        $query->andFilterWhere(['like', 'usuarios.nombre_apellidos', $this->autor_nombre_apellidos]);

        return $dataProvider;
    }
    
    /**
     * Gets the public filter options.
     * 
     * @return array
     */
    public static function getPublicFilterOptions()
    {
        return [
            '' => 'Todos',
            '1' => 'Públicas',
            '0' => 'Privadas',
        ];
    }
}
