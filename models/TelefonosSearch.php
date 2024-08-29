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
        $query->joinWith('usuario'); // Ensure 'usuario' is the correct relation name

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'nombre_apellidos',
                    'email',
                    'telefono',
                    'usuario_nombre_apellidos' => [
                        'asc' => ['usuarios.nombre_apellidos' => SORT_ASC],
                        'desc' => ['usuarios.nombre_apellidos' => SORT_DESC],
                        'label' => 'Usuario Nombre Apellidos',
                    ],
                    'usuario_username' => [
                        'asc' => ['usuarios.username' => SORT_ASC],
                        'desc' => ['usuarios.username' => SORT_DESC],
                        'label' => 'Username',
                    ],
                    'usuario_email' => [
                        'asc' => ['usuarios.email' => SORT_ASC],
                        'desc' => ['usuarios.email' => SORT_DESC],
                        'label' => 'Usuario Email',
                    ],
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // Uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'telefonos.id' => $this->id,
            'telefonos.telefono' => $this->telefono,
        ]);

        $query->andFilterWhere(['like', 'usuarios.nombre_apellidos', $this->nombre_apellidos])
            ->andFilterWhere(['like', 'telefonos.email', $this->email])
            ->andFilterWhere(['like', 'usuarios.nombre_apellidos', $this->usuario_nombre_apellidos])
            ->andFilterWhere(['like', 'usuarios.username', $this->usuario_username])
            ->andFilterWhere(['like', 'usuarios.email', $this->usuario_email]);

        return $dataProvider;
    }
}
