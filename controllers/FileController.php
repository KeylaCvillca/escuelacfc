<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\web\NotFoundHttpException;
use yii\helpers\FileHelper;
use yii\web\Response;
use app\models\File;
use app\models\FileSearch;

class FileController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new FileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Modify the dataProvider for path-based filtering
        $dataProvider->sort->attributes['name'] = [
            'asc' => ['path' => SORT_ASC],
            'desc' => ['path' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['extension'] = [
            'asc' => ['path' => SORT_ASC],
            'desc' => ['path' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['path'] = [
            'asc' => ['path' => SORT_ASC],
            'desc' => ['path' => SORT_DESC],
        ];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($path)
    {
        $filePath = Yii::getAlias('@webroot') . '/' . $path;
        
        if (!file_exists($filePath)) {
            throw new NotFoundHttpException('El archivo no existe.');
        }

        $fileInfo = pathinfo($filePath);
        $extension = strtolower($fileInfo['extension']);
        $mimeType = mime_content_type($filePath);

        return $this->render('view', [
            'filePath' => $filePath,
            'mimeType' => $mimeType,
            'extension' => $extension,
        ]);
    }

    public function actionDownload($path)
    {
        $filePath = Yii::getAlias('@webroot') . $path;

        if (!file_exists($filePath)) {
            throw new NotFoundHttpException("El archivo no existe.");
        }

        return Yii::$app->response->sendFile($filePath, basename($filePath), ['inline' => false]);
    }

    public function actionDelete($path)
    {
        $filePath = Yii::getAlias('@webroot') . $path;

        if (!file_exists($filePath)) {
            throw new NotFoundHttpException("El archivo no existe.");
        }

        if (unlink($filePath)) {
            Yii::$app->session->setFlash('success', "El archivo ha sido eliminado.");
        } else {
            Yii::$app->session->setFlash('error', "No se pudo eliminar el archivo.");
        }

        return $this->redirect(['index']);
    }
}
