<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

class AddUserForm extends Model
{
    public $nombre_apellidos;
    public $rol;
    public $fecha_nacimiento;
    public $celula;
    public $fecha_ingreso;
    public $fecha_graduacion;
    public $foto;
    public $color;
    public $username;
    public $password;
    public $email;
    public $pais;
    public $created_at;
    public $updated_at;
    public $status;
    public $telefonos = [];
    public $id;

    /**
     * @var UploadedFile
     */
    public $fotoFile;

    public function rules()
    {
        return [
             [['nombre_apellidos', 'email', 'fecha_nacimiento', 'celula', 'fecha_ingreso', 'fecha_graduacion', 'foto', 'color', 'telefonos'], 'safe'],
            [['username', 'email', 'password', 'created_at', 'updated_at'], 'required', 'on' => self::SCENARIO_CREATE],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['nombre_apellidos'], 'string', 'max' => 50],
            [['rol'], 'string', 'max' => 40],
            [['celula'], 'string', 'max' => 20],
            [['foto', 'username', 'password', 'email'], 'string', 'max' => 255],
            [['color'], 'string', 'max' => 15],
            [['email'], 'email'],
            [['email', 'username'], 'unique', 'targetClass' => Usuarios::class, 'on' => self::SCENARIO_CREATE],
            [['color'], 'exist', 'skipOnError' => true, 'targetClass' => Niveles::class, 'targetAttribute' => ['color' => 'color']],

        ];
    }
    
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['nombre_apellidos', 'rol', 'fecha_nacimiento', 'celula', 'fecha_ingreso', 'fecha_graduacion', 'foto', 'color', 'username', 'password', 'email', 'telefonos', 'created_at', 'updated_at', 'status'];
        $scenarios[self::SCENARIO_UPDATE] = ['nombre_apellidos', 'email', 'fecha_nacimiento', 'celula', 'fecha_ingreso', 'fecha_graduacion', 'foto', 'color', 'telefonos'];
        return $scenarios;
    }

    public function addUser()
    {
        $user = new Usuarios();

        $nombrePart = substr(str_replace(' ', '', $this->nombre_apellidos), 0, 4);
        $celulaPart = substr($this->celula, 0, 3);
        $datePart = date('dm');
        $this->username = strtolower($nombrePart . $celulaPart . $datePart);

        if ($this->validate()) {
            if ($this->fotoFile) {
                $this->foto = $this->saveFoto($user);
            }
            $this->populateUser($user);
            return $user->save();
        }
        return false;
    }

    public function updateUser($id)
    {
        $user = Usuarios::findOne($id);

        if (!$user) {
            return false;
        }

        if ($this->validate()) {
            if ($this->fotoFile) {
                $this->foto = $this->saveFoto($user);
            }
            $this->populateUser($user, false);
            return $user->save();
        }
        return false;
    }

    private function saveFoto($user)
    {
        $filename = strtolower($user->username) . '.' . $this->fotoFile->extension;
        $filePath = Yii::getAlias('@webroot') . '/imagenes/usuarios/' . $filename;
        if ($this->fotoFile->saveAs($filePath)) {
            return $filename;
        }
        return null;
    }

    private function populateUser($user, $isNew = true)
    {
        $user->nombre_apellidos = $this->nombre_apellidos;
        $user->rol = $this->rol;
        $user->fecha_nacimiento = $this->fecha_nacimiento;
        $user->celula = $this->celula;
        $user->fecha_ingreso = $this->fecha_ingreso;
        $user->fecha_graduacion = $this->fecha_graduacion;
        $user->foto = $this->foto;
        $user->color = $this->color;
        $user->username = $this->username;
        $user->email = $this->email;
        if ($this->password) {
            $user->password_hash = User::generateHash($this->password);
        }
        if ($isNew) {
            $user->auth_key = Yii::$app->security->generateRandomString();
            $user->status = 10;
            $user->created_at = time();
        }
        $user->updated_at = time();

        // Handle phone numbers
        foreach ($this->telefonos as $numero) {
            $telefono = new Telefonos();
            $telefono->usuario = $user->id;
            $telefono->telefono = $numero;
            $telefono->save();
        }
    }
}
