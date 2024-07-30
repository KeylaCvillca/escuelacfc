<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\data\ActiveDataProvider;
use app\models\Instrumentos;
use yii\helpers\FileHelper;
use yii\web\NotFoundHttpException;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $instrumentos= new ActiveDataProvider([
            'query' => Instrumentos::find()->select("*")
            
        ]);
        
        return $this->render('index',[
            'instrumentos' => $instrumentos->models,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->actionLogin();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    
    public function actionUpload()
    {
       
        
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->validate()) {
                $filePath = ($model->file->extension==='mp4'?'videos/':'imagenes/') .
                                 $model->file->baseName . '.' . $model->file->extension; //);
                if ($model->file->saveAs($filePath)) {
                    Yii::$app->session->setFlash('success', 'El archivo ha sido subido exitosamente.');
                } else {
                    Yii::$app->session->setFlash('error', 'Hubo un error al subir el archivo.');
                }
                return $this->refresh();
            }
        }

        return $this->render('upload', ['model' => $model]);
    }

    public function actionFiles()
    {
       
        
        $files = array_merge(FileHelper::findFiles('imagenes'), FileHelper::findFiles('videos'));
        return $this->render('files', ['files' => $files]);
    }

    public function actionViewFile($filename)
    {
        $imagePath = Yii::getAlias('@web/imagenes/' . $filename);
        $videoPath = Yii::getAlias('@web/videos/' . $filename);

        if (!file_exists($imagePath) && !file_exists($videoPath)) {
            throw new NotFoundHttpException('The requested file does not exist.');
        }

        $filePath = file_exists($imagePath) ? $imagePath : $videoPath;
        return $this->renderAjax('view-file', ['filePath' => $filePath, 'filename' => $filename]);
    }

    
    public function actionDownloadFile($filename)
    {
        
        
        $filePath = Yii::getAlias('@web/imagenes/' . $filename);
        if (!file_exists($filePath)) {
            $filePath = Yii::getAlias('@web/videos/' . $filename);
            if (!file_exists($filePath)) {
                throw new NotFoundHttpException('The requested file does not exist.');
            }
        }
        return Yii::$app->response->sendFile($filePath);
    }

    public function actionDeleteFile($filename)
    { 
        $filePath = Yii::getAlias('@webroot/imagenes/' . $filename);
        if (!file_exists($filePath)) {
            $filePath = Yii::getAlias('@webroot/videos/' . $filename);
        }

        if (file_exists($filePath)) {
            unlink($filePath);
            Yii::$app->session->setFlash('success', 'The file has been deleted successfully.');
        } else {
            Yii::$app->session->setFlash('error', 'There was an error deleting the file.');
        }
        return $this->redirect(['site/files']);
    }
    
    
}
