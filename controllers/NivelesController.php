<?php

namespace app\controllers;

use app\models\Niveles;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * NivelesController implements the CRUD actions for Niveles model.
 */
class NivelesController extends Controller
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
     * Lists all Niveles models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Niveles::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'color' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Niveles model.
     * @param string $color Color
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($color)
    {
        return $this->render('view', [
            'model' => $this->findModel($color),
        ]);
    }

    /**
     * Creates a new Niveles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Niveles();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('¡Nivel creado exitosamente!');
                return $this->redirect(['view', 'color' => $model->color]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Niveles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $color Color
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($color)
    {
        $model = $this->findModel($color);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'color' => $model->color]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Niveles model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $color Color
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($color)
    {
        $this->findModel($color)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Niveles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $color Color
     * @return Niveles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($color)
    {
        if (($model = Niveles::findOne(['color' => $color])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
