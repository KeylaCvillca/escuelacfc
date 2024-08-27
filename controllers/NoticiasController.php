<?php

namespace app\controllers;

use app\models\Noticias;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use app\models\Usuarios;
use yii\data\Pagination;

/**
 * NoticiasController implements the CRUD actions for Noticias model.
 */
class NoticiasController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Noticias models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Noticias::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Noticias model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        // Obtener la información del autor
        $autor = Usuarios::findOne($model->autor);
        $autorNombreApellidos = $autor ? $autor->nombre_apellidos : 'Desconocido';
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'autorNombreApellidos' => $autorNombreApellidos,
        ]);
    }

    /**
     * Creates a new Noticias model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Noticias();


        if ($this->request->isPost) {
            $model->autor= Yii::$app->user->identity->id;
            $model->fecha_publicacion=date('Y-m-d H:i:s');
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Noticias model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Noticias model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Noticias model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Noticias the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Noticias::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    
    public function actionRead()
    {
        // Configurar la paginación
        $query = Noticias::find(); // Usa el modelo Noticias
        $pagination = new Pagination([
            'defaultPageSize' => 10, // Número de noticias por página
            'totalCount' => $query->count(),
        ]);

        $noticias = $query->offset($pagination->offset)
                          ->limit($pagination->limit)
                          ->all();

        // No es necesario aquí, el método en el modelo se encarga de obtener el nombre del autor
        // foreach ($noticias as $noticia) {
        //     $autor = Usuarios::findOne($noticia->autor);
        //     $noticia->autorNombreApellidos = $autor ? $autor->nombre_apellidos : 'Desconocido';
        // }

        return $this->render('read', [
            'noticias' => $noticias,
            'pagination' => $pagination,
        ]);
    }
    
    public function actionMisnoticias()
    {
        // Crear un ActiveDataProvider para listar las noticias del usuario actual
        $dataProvider = new ActiveDataProvider([
            'query' => Noticias::find()->where(['autor' => Yii::$app->user->id]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('misnoticias', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionPublic() {
        // Configurar la paginación
        $query = Noticias::find()->where(['publico' => true]); // Usa el modelo Noticias
        $pagination = new Pagination([
            'defaultPageSize' => 10, // Número de noticias por página
            'totalCount' => $query->count(),
        ]);

        $noticias = $query->offset($pagination->offset)
                          ->limit($pagination->limit)
                          ->all();

        return $this->render('public', [
            'noticias' => $noticias,
            'pagination' => $pagination,
        ]);
    }
    
    
}
