<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\AddUserForm;

class AddUserFormController extends Controller
{
    public function actionCreate()
    {
        $model = new AddUserForm();

        if ($model->load(Yii::$app->request->post()) && $model->addUser()) {
            Yii::$app->session->setFlash('success', 'Usuario creado exitosamente.');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
}

