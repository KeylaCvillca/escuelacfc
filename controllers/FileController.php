<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\web\NotFoundHttpException;
use yii\helpers\FileHelper;
use yii\web\Response;
use app\models\File;

class FileController extends Controller
{
    public function actionIndex()
    {
        $paths = [
            Yii::getAlias('@webroot/imagenes'),
            Yii::getAlias('@webroot/videos'),
            Yii::getAlias('@webroot/excel'),
        ];

        $files = [];
        foreach ($paths as $basePath) {
            $allFiles = FileHelper::findFiles($basePath);
            foreach ($allFiles as $filePath) {
                $file = new File();
                $file->name = basename($filePath);
                $file->extension = pathinfo($filePath, PATHINFO_EXTENSION);
                $file->path = str_replace(Yii::getAlias('@webroot'), '', $filePath);
                $files[] = $file;
            }
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $files,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
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
