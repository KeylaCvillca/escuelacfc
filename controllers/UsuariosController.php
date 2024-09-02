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
use app\models\Niveles;
use app\models\Ensenan;
use app\models\UploadExcelForm;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use app\models\Telefonos;
use yii\helpers\ArrayHelper;
use app\models\Noticias;

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
         $model->change_password = true;

        if ($model->load(Yii::$app->request->post())) {
            $model->created_at = time();
            $model->updated_at = time();

            if ($model->AddUser()) {
                Yii::$app->session->setFlash('success', 'Usuario guardado exitosamente.');
                return $this->redirect(['view', 'id' => Usuarios::findOne(['email' => $model->email])->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Error al guardar el usuario.');
            }
        }


        // Fetch all distinct levels for maestras
        $niveles = Niveles::find()->select(['color'])->distinct()->all();

        return $this->render('create', [
            'model' => $model,
            'niveles' => $niveles,
        ]);
    }

    public function actionMisdatos()
    {
        $user = $this->findModel(Yii::$app->user->id);
        $model = new AddUserForm();
        $model->setScenario(AddUserForm::SCENARIO_UPDATE);
        $model->attributes = $user->attributes;
        Yii::debug( $model->attributes);
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {

                if ($model->change_password) {
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password);
                } else {
                    // Si no se cambia la contraseña, mantenemos el hash anterior
                    $model->password_hash = $user->password_hash;
                }
                $model->fotoFile = UploadedFile::getInstance($model, 'fotoFile');
                $user->attributes =$model->attributes;
                if ($model->fotoFile) {
                    // Definir la ruta completa para guardar la imagen
                    $fileName = 'imagenes/usuarios/' . $model->fotoFile->baseName . '.' . $model->fotoFile->extension;
                    $filePath = Yii::getAlias('@webroot') . '/' . $fileName;

                    // Guardar la foto en el servidor
                    if ($model->fotoFile->saveAs($filePath)) {
                        // Si la foto se guarda correctamente, actualiza la ruta en el modelo de usuario
                        $user->foto = $model->fotoFile->baseName . '.' . $model->fotoFile->extension;
                    } else {
                        Yii::$app->session->setFlash('error', 'Error al subir la foto.');
                    }
                }
                
                if ($user->save(false)) {
                    Yii::$app->session->setFlash('success', 'Los datos han sido actualizados.');
                    return $this->render('misdatos', [
                        'model' => $model,
                        'user' => $user,
                    ]);
                } else {
                    Yii::$app->session->setFlash('error', 'Error al actualizar los datos.');
                }
            }
        }
        
        return $this->render('misdatos', [
            'model' => $model,
            'user' => $user,
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
        $user = Usuarios::findOne($id);

        if (!$user) {
            throw new NotFoundHttpException('User not found.');
        }

        $model = new AddUserForm();
        $model->scenario = AddUserForm::SCENARIO_UPDATE;
        $model->attributes = $user->attributes;

        if (Yii::$app->request->isPost) {
            $model->fotoFile = UploadedFile::getInstance($model, 'fotoFile');
            if ($model->load(Yii::$app->request->post()) && $model->updateUser($id)) {
                Yii::$app->session->setFlash('success', 'Your data has been updated.');
                return $this->redirect(['view', 'id' => Usuarios::findOne(['email' => $model->email])->id]);
            }
        }
        
        $niveles = Niveles::find()->select(['color'])->distinct()->all();

        return $this->render('update', [
            'model' => $model,
            'niveles' => $niveles,
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
        Noticias::deleteAll(['autor' => $id]);
        Telefonos::deleteAll(['usuario' => $id]);
        Ensenan::deleteAll(['maestra' => $id]);
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
    
    public function actionAlumnas()
    {
        // Obtener el ID del usuario actual
        $maestraId = Yii::$app->user->identity->id;

        // Obtener todos los colores (niveles) en los que enseña la maestra actual
        $niveles = Ensenan::find()
            ->select('color')
            ->distinct()
            ->where(['maestra' => $maestraId])
            ->column();

        // Si no hay niveles asociados, no es necesario continuar
        if (empty($niveles)) {
            return $this->render('alumnas', [
                'dataProvider' => null,
            ]);
        }

        // Crear un ActiveDataProvider para manejar las alumnas
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => Usuarios::find()->where(['rol' => 'alumna', 'color' => $niveles]),
            'pagination' => [
                'pageSize' => 20, // Número de alumnas por página
            ],
        ]);

        // Renderizar la vista y pasar el dataProvider
        return $this->render('alumnas', [
            'dataProvider' => $dataProvider,
        ]);
    }


    
    public function actionUpload()
    {
        $model = new UploadExcelForm();
        if (Yii::$app->request->isPost) {
            if (empty($model->color)) {
                // Si el color está vacío, no lo actualices
                unset($model->color);
            }
            $model->file = UploadedFile::getInstance($model, 'file');
            $uploaded = $model->upload();
            if ($uploaded) {
                 set_time_limit(500);
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $this->importUsersFromExcel($model->getPath());
                    $transaction->commit();
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e; // Or handle the error appropriately
                }
                Yii::$app->session->setFlash('success', 'Usuarios cargados exitosamente.');
                return $this->redirect(['index']);
            }
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => [
                [
                    'A: nombre_apellidos' => 'Juana Pérez',
                    'B: rol' => 'maestra',
                    'C: fecha_nacimiento' => '1980-05-15',
                    'D: celula' => 'Su Presencia',
                    'E: fecha_ingreso' => '2023-01-10',
                    'F: fecha_graduacion' => '2024-12-20',
                    'G: email' => 'juana.perez@example.com',
                    'H: color' => 'rosa',
                    'I: password' => '1234pass',
                    'J: telefonos' => '34-623576879,34-712345678',
                    'K: niveles' => '1,2',
                    'L: funciones' => 'auxiliar,titular',
                ],
                [
                    'A: nombre_apellidos' => 'Juan Pérez',
                    'B: rol' => 'maestra',
                    'C: fecha_nacimiento' => '1980-05-15',
                    'D: celula' => 'Efraín',
                    'E: fecha_ingreso' => '2023-01-10',
                    'F: fecha_graduacion' => '2024-12-20',
                    'G: email' => 'juan.perez@example.com',
                    'H: color' => 'rosa',
                    'I: password' => '1234pass',
                    'J: telefonos' => '34-699124356,34-692385471',
                    'K: niveles' => '1,2,3',
                    'L: funciones' => 'titular,auxiliar,auxiliar',
                ]
            ],
        ]);

        return $this->render('upload', [
            'dataProvider' => $dataProvider,
            'model' => new UploadExcelForm(),
        ]);

       
    }

    protected function importUsersFromExcel($filePath)
    {
        $reader = new Xlsx();
        $spreadsheet = $reader->load($filePath);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        foreach ($sheetData as $key => $row) {
            if ($key == 1) {
                continue; // Skip header row
            }

            $usuario = new Usuarios();
            $usuario->nombre_apellidos = $row['A'];
            $usuario->rol = $row['B'];
            $usuario->fecha_nacimiento = $row['C'];
            $usuario->celula = $row['D'];
            $usuario->fecha_ingreso = $row['E'];
            $usuario->fecha_graduacion = $row['F'];
            $usuario->email = $row['G'];
            $usuario->color = $row['H'];
            $usuario->username = $this->generateUsername($usuario->nombre_apellidos, $usuario->celula);
            $usuario->password_hash = Yii::$app->security->generatePasswordHash($row['I']);
            $usuario->auth_key = Yii::$app->security->generateRandomString();
            $usuario->status = 10;
            $usuario->created_at = time();
            $usuario->updated_at = time();

            if ($usuario->save()) {
                if (!empty($row['J'])) {
                    $telefonos = explode(',', $row['J']);
                    foreach ($telefonos as $numero) {
                        $telefono = new Telefonos();
                        $telefono->usuario = $usuario->id;
                        $telefono->telefono = $numero;
                        $telefono->save();
                    }
                }

                if ($usuario->rol === 'maestra' && !empty($row['K']) && !empty($row['L'])) {
                    $niveles = explode(',', $row['K']);
                    $funciones = explode(',', $row['L']);

                    foreach ($niveles as $index => $nivel) {
                        $ensenan = new Ensenan();
                        $ensenan->maestra = $usuario->id;
                        $ensenan->color = $nivel;
                        $ensenan->funcion = $funciones[$index] ?? null;
                        $ensenan->save();
                    }
                }

                $this->assignRole($usuario->id, $usuario->rol);
            }
        }
    }

    protected function generateUsername($nombreApellidos, $celula)
{
    // Normalize accented characters
    $nombreApellidos = $this->normalizeString($nombreApellidos);
    $celula = $this->normalizeString($celula);

    // Remove all whitespaces
    $nombreApellidos = str_replace(' ', '', $nombreApellidos);
    $celula = str_replace(' ', '', $celula);

    // Generate username parts
    $nombrePart = substr($nombreApellidos, 0, 4);
    $celulaPart = substr($celula, 0, 3);
    $datePart = date('dm');

    return strtolower($nombrePart . $celulaPart . $datePart);
}

    protected function normalizeString($string)
    {
        // Convert accented characters to their non-accented equivalents
        $normalized = strtr(
            utf8_decode($string),
            utf8_decode('áàäâãåçéèëêíìïîñóòöôõúùüûýÿÁÀÄÂÃÅÇÉÈËÊÍÌÏÎÑÓÒÖÔÕÚÙÜÛÝŸ'),
            'aaaaaaceeeeiiiinooooouuuuyyAAAAAACEEEEIIIINOOOOOUUUUYY'
        );

        return utf8_encode($normalized);
    }

    protected function assignRole($userId, $rol)
    {
        Yii::$app->db->createCommand()->delete('auth_assignment', ['user_id' => $userId])->execute();
        Yii::$app->db->createCommand()->insert('auth_assignment', [
            'item_name' => $rol,
            'user_id' => $userId,
            'created_at' => time(),
        ])->execute();
    }
}
