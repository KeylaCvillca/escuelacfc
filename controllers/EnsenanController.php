<?php

namespace app\controllers;

use app\models\Ensenan;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Usuarios;
use app\models\Niveles;
use yii\data\SqlDataProvider;
use Yii;

/**
 * EnsenanController implements the CRUD actions for Ensenan model.
 */
class EnsenanController extends Controller
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
     * Lists all Ensenan models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new SqlDataProvider([
        'sql' => '
            SELECT usuarios.nombre_apellidos AS nombre, ensenan.color, ensenan.funcion
            FROM ensenan
            INNER JOIN usuarios ON ensenan.maestra = usuarios.id
        ',

        'sort' => [
            'attributes' => [
                'maestra',
                'color',
                'funcion',
            ],
        ],
    ]);

    return $this->render('index', [
        'dataProvider' => $dataProvider,
    ]);
    }

    /**
     * Displays a single Ensenan model.
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
     * Creates a new Ensenan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Ensenan();

        // Fetch all maestras
        $maestras = Usuarios::find()->where(['rol' => 'maestra'])->all();
        $niveles = Niveles::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'maestras' => $maestras,
            'niveles' => $niveles,
        ]);
    }

    /**
     * Updates an existing Ensenan model.
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
     * Deletes an existing Ensenan model.
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
     * Finds the Ensenan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Ensenan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ensenan::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
