<?php

namespace app\controllers;

use app\models\Telefonos;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\TelefonosSearch;
use app\models\Usuarios;
use Yii;

/**
 * TelefonosController implements the CRUD actions for Telefonos model.
 */
class TelefonosController extends Controller
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
     * Lists all Telefonos models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TelefonosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Telefonos model.
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
     * Creates a new Telefonos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Telefonos();

        if ($this->request->isPost) {
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
     * Updates an existing Telefonos model.
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
     * Deletes an existing Telefonos model.
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
     * Finds the Telefonos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Telefonos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Telefonos::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionAdd($userid)
    {
        $paises = [
            'US' => '+1',
            'CA' => '+1',
            'MX' => '+52',
            'ES' => '+34',
            // Añade más prefijos según sea necesario
        ];

        if (Yii::$app->request->isPost) {
            $telefonos = Yii::$app->request->post('telefonos');
            $paisesSeleccionados = Yii::$app->request->post('paises');

            foreach ($telefonos as $index => $telefono) {
                $pais = $paisesSeleccionados[$index] ?? 'US'; // Default to 'US' if no country selected
                $prefijo = $paises[$pais] ?? '';

                $model = new Telefonos();
                $model->usuario = $userid;
                $model->telefono = $prefijo . $telefono;

                if (!$model->save()) {
                    Yii::$app->session->setFlash('error', 'Error al añadir algunos teléfonos.');
                    return $this->redirect(['usuarios/misdatos']);
                }
            }

            Yii::$app->session->setFlash('success', 'Teléfonos añadidos correctamente.');
            return $this->redirect(['misdatos']); // Redirigir a la vista de misdatos
        }

        return $this->render('add', [
            'paises' => $paises, // Pasar los países y prefijos a la vista si es necesario
        ]);
    }
}
