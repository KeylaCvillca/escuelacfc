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
use yii\web\UploadedFile;

class FileController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new FileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
        $realPath = File::getRealPath($path);
        $filePath = Yii::getAlias('@web') . str_replace('web/','',str_replace('\\','/',$path));
        Yii::debug($realPath);
        Yii::debug($filePath);
        if (!file_exists($realPath)) {
            throw new NotFoundHttpException('El archivo no existe.');
        }

        $fileInfo = pathinfo($realPath);
        $extension = strtolower($fileInfo['extension']);
        $mimeType = mime_content_type($realPath);

        return $this->render('view', [
            'filePath' => $filePath,
            'mimeType' => $mimeType,
            'extension' => $extension,
        ]);
    }

    public function actionDownload($path)
    {

        $realPath = File::getRealPath($path);

        if (!file_exists($realPath)) {
            throw new NotFoundHttpException('El archivo no existe.');
        }

        return Yii::$app->response->sendFile($realPath, basename($realPath), ['inline' => false]);
    }


    public function actionDelete($path)
    {

        $realPath = File::getRealPath($path);

        if (!file_exists($realPath)) {
            throw new NotFoundHttpException('El archivo no existe.');
        }

        if (unlink($realPath)) {
            Yii::$app->session->setFlash('success', 'El archivo ha sido eliminado.');
        } else {
            Yii::$app->session->setFlash('error', 'No se pudo eliminar el archivo.');
        }

        return $this->redirect(['index']);
    }  
}
