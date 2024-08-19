<?php

namespace app\controllers;

use app\models\Usuarios;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\AddUserForm;
use Yii;
use yii\web\UploadedFile;
use app\models\UsuariosSearch;
use app\models\EnsenanSearch;


/**
 * UsuariosController implements the CRUD actions for Usuarios model.
 */
class UsuariosController extends Controller
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
     * Lists all Usuarios models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UsuariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Filters for "maestra" and "alumna" roles
        $maestraProvider = clone $dataProvider;
        $maestraProvider->query->andFilterWhere(['rol' => 'maestra']);

        $alumnaProvider = clone $dataProvider;
        $alumnaProvider->query->andFilterWhere(['rol' => 'alumna']);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'maestraProvider' => $maestraProvider,
            'alumnaProvider' => $alumnaProvider,
        ]);
    }

    /**
     * Displays a single Usuarios model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Usuarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new AddUserForm();
        $model->scenario = AddUserForm::SCENARIO_CREATE;
        $model->fotoFile = UploadedFile::getInstance($model, 'fotoFile');

        if ($model->load(Yii::$app->request->post()) && $model->addUser()) {
            Yii::$app->session->setFlash('success', 'User created successfully.');
            return $this->redirect(['create']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionMisdatos()
    {
        $userId = Yii::$app->user->id;
        $user = Usuarios::findOne($userId);

        if (!$user) {
            throw new NotFoundHttpException('User not found.');
        }

        $model = new AddUserForm();
        $model->scenario = AddUserForm::SCENARIO_UPDATE;
        $model->attributes = $user->attributes;

        if (Yii::$app->request->isPost) {
            $model->fotoFile = UploadedFile::getInstance($model, 'fotoFile');
            if ($model->load(Yii::$app->request->post()) && $model->updateUser($userId)) {
                Yii::$app->session->setFlash('success', 'Your data has been updated.');
                return $this->redirect(['misdatos']);
            }
        }

        return $this->render('misdatos', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing Usuarios model.
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
     * Deletes an existing Usuarios model.
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
     * Finds the Usuarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Usuarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuarios::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
     // Acción para gestionar la relación entre maestras, niveles y funciones
    public function actionMaestras()
    {
        $searchModel = new EnsenanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('maestras', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
