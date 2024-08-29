<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Telefonos;

/**
 * TelefonosSearch represents the model behind the search form of `app\models\Telefonos`.
 */
class TelefonosSearch extends Telefonos
{
    public $usuario_nombre_apellidos; // Alias for searchable attributes
    public $usuario_email;
    public $usuario_username;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['nombre_apellidos', 'email', 'telefono', 'usuario_nombre_apellidos', 'usuario_email', 'usuario_username'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates a data provider instance with search query applied.
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Telefonos::find();
        
        // Join with usuarios table
        $query->joinWith('usuario'); // Adjust the relation name based on your model

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        // Validate the parameters
        if (!$this->validate()) {
            // Uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // Grid filtering conditions
        $query->andFilterWhere([
            'telefonos.id' => $this->id,
            'telefonos.telefono' => $this->telefono,
        ]);

        $query->andFilterWhere(['like', 'usuarios.nombre_apellidos', $this->nombre_apellidos])
            ->andFilterWhere(['like', 'usuarios.username', $this->usuario_username])
            ->andFilterWhere(['like', 'usuarios.email', $this->usuario_email]);

        return $dataProvider;
    }
}
