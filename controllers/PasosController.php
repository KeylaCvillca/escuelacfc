<?php

namespace app\controllers;

use app\models\Pasos;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Mpdf\Mpdf;
use app\models\Niveles;
use app\models\PasosSearch;
use Yii;
use yii\web\UploadedFile;

/**
 * PasosController implements the CRUD actions for Pasos model.
 */
class PasosController extends Controller
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
     * Lists all Pasos models.
     *
     * @return string
     */
    public function actionIndex()
{
    $searchModel = new PasosSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    $dataProvider->pagination = false;
    return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]);
}

    /**
     * Displays a single Pasos model.
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
     * Creates a new Pasos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Pasos();

        // Si la petición es POST
        if ($this->request->isPost) {
            // Cargar datos del formulario en el modelo
            $model->load($this->request->post());
            // Obtener el archivo de imagen
            $model->imagenFile = UploadedFile::getInstance($model, 'imagenFile');

            // Validar el modelo
            if ($model->validate()) {
                // Si se sube una imagen, guarda el archivo
                if ($model->imagenFile) {
                    $model->imagen = strtolower($model->nombre) . '.' . $model->imagenFile->extension;
                    if ($model->uploadImage()) {
                        // Guardar el modelo
                        if ($model->save(false)) {
                            return $this->redirect(['view', 'id' => $model->id]);
                        }
                    }
                } else {
                    // Guardar el modelo sin imagen
                    if ($model->save(false)) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            $model->imagenFile = UploadedFile::getInstance($model, 'imagenFile');

            if ($model->imagenFile) {
                    $model->imagen = strtolower($model->nombre) . '.' . $model->imagenFile->extension;
                    if ($model->uploadImage()) {
                        // Guardar el modelo
                        if ($model->save(false)) {
                            return $this->redirect(['view', 'id' => $model->id]);
                        }
                    }
                } else {
                    // Guardar el modelo sin imagen
                    if ($model->save(false)) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Pasos model.
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
     * Finds the Pasos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Pasos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pasos::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionDownloadPdf($id) {
        // Find your model by ID
        $model = Pasos::findOne($id);

        // Check if the model exists
        if ($model === null) {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }

        // Generate the PDF content
        $content = $this->renderPartial('_pdf_template', ['model' => $model]); // Use a partial view to render your model data in PDF

        // Setup the PDF
        $pdf = new mPDF();
        $pdf->WriteHTML($content);

        // Output the PDF as a downloadable file
        $pdf->Output('filename.pdf', 'D'); // 'D' sends the file inline to the browser (default), 'F' saves to a file

        // Exit to prevent Yii from rendering any view
        Yii::$app->end();
    }
    
    public function actionQuiz() {
        // Obtenemos todos los pasos usando ActiveDataProvider
        $dataProvider = new ActiveDataProvider([
            'query' => Pasos::find(),
            'pagination' => false, // Deshabilitamos la paginación para obtener todos los registros
        ]);
        
        // Convertimos el ActiveDataProvider a un array de modelos
        $models = $dataProvider->getModels();
        $questions = [];
        $answers = [];
    
        for ($i = 0; $i < 4; $i++) {
            // Selecciona un elemento aleatorio y obtén su modelo
            $itemIndex = array_rand($models);
            $questions[$i][0] = $models[$itemIndex];
            
            // Elimina el elemento seleccionado y reindexa el array
            array_splice($models, $itemIndex, 1);
    
            for ($j = 1; $j < 4; $j++) {
                // Selecciona un elemento aleatorio de los restantes y obtén su modelo
                $itemIndex = array_rand($models);
                $questions[$i][$j] = $models[$itemIndex];
                
                // Elimina el elemento seleccionado y reindexa el array
                array_splice($models, $itemIndex, 1);
            }
    
            // Guarda la respuesta correcta
            $answers[$i] = $questions[$i][0];
            
            // Baraja las respuestas
            shuffle($questions[$i]);
        }
    
        return $this->render('quiz', [
            'questions' => $questions,
            'answers' => $answers
        ]);
    }
}
