<?php

namespace app\models;

use yii\base\Model;
use Yii;
use app\models\Usuarios;
use app\models\Telefonos;
use app\models\Niveles;

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
    public $confirm_password;
    public $email;
    public $pais;
    public $created_at;
    public $updated_at;
    public $status;
    public $telefonos = [];
    public $id;
    public $auth_key;
    public $password_hash;
    public $password_reset_token;
    public $scenario;
    public $fotoFile;
    public $change_password;

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public function rules()
    {
        return [
            [['username', 'email', 'created_at', 'updated_at','color'], 'required'],
            [['fecha_nacimiento', 'fecha_ingreso', 'fecha_graduacion'], 'safe'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['nombre_apellidos'], 'string', 'max' => 50],
            [['rol'], 'string', 'max' => 40],
            [['celula'], 'string', 'max' => 20],
            [['foto', 'username', 'password', 'email'], 'string', 'max' => 255],
            [['color'], 'string', 'max' => 15],
            [['email'], 'email'],
            [['email', 'username'], 'unique', 'targetClass' => Usuarios::class],
            [['color'], 'exist', 'skipOnError' => true, 'targetClass' => Niveles::class, 'targetAttribute' => ['color' => 'color']],
            [['telefonos'], 'each', 'rule' => ['string', 'max' => 15]],
            [['fotoFile'], 'file', 'extensions' => 'png, jpg, jpeg', 'skipOnEmpty' => true],
            [['change_password'], 'boolean'],
            ['password', 'required', 'when' => function ($model) {
                return $model->change_password;
            }],
            ['password', 'string', 'min' => 8, 'when' => function ($model) {
                return $model->change_password;
            }],
            ['password', 'match', 'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[.,;_])[A-Za-z\d.,;_]{8,}$/', 'when' => function ($model) {
                return $model->change_password;
            }],
            ['confirm_password', 'required', 'when' => function ($model) {
                return $model->change_password;
            }],
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'when' => function ($model) {
                return $model->change_password;
            }],
        ];
    }

    public function attributeLabels() {
        return [
            'password' => 'Contraseña',
            'confirm_password' => 'Confirmar contraseña',
            'change_password' => 'Cambiar contraseña'
        ];
    }

    public function addUser()
    {
        $user = new Usuarios();
        
        // Generate a unique username
        $nombrePart = substr(str_replace(' ', '', $this->nombre_apellidos), 0, 4);
        $celulaPart = substr($this->celula, 0, 3);          
        $datePart = date('dm');                            
        $this->username = strtolower($nombrePart . $celulaPart . $datePart);
        
        if ($this->validate()) {
            // Assign attributes individually
            $user->username = $this->username;
            $user->password_hash = Yii::$app->security->generatePasswordHash($this->password);
            $user->auth_key = Yii::$app->security->generateRandomString();
            $user->status = 10; 
            $user->created_at = time();
            $user->updated_at = time();
            $user->nombre_apellidos = $this->nombre_apellidos;
            $user->rol = $this->rol;
            $user->fecha_nacimiento = $this->fecha_nacimiento;
            $user->celula = $this->celula;
            $user->fecha_ingreso = $this->fecha_ingreso;
            $user->fecha_graduacion = $this->fecha_graduacion;
            $user->foto = $this->foto;
            $user->color = $this->color;
            $user->email = $this->email;

            if ($user->save()) {
                // Save phones
                foreach ($this->telefonos as $numero) {
                    if ($numero == "") {
                        continue;
                    }
                    $telefono = new Telefonos();
                    $telefono->usuario = Usuarios::findOne(['email' => $user->email])->id;
                    $telefono->telefono = $numero;
                    $telefono->save();
                }
                $this->assignRole($user->id);
                return true;
            }
        }

        return false;
    }

    public function assignRole($userId)
    {
        // Remove the previous role assignment, if any
        Yii::$app->db->createCommand()
            ->delete('auth_assignment', ['user_id' => $userId])
            ->execute();

        // Assign the new role
        Yii::$app->db->createCommand()->insert('auth_assignment', [
            'item_name' => $this->rol,
            'user_id' => $userId,
            'created_at' => time(),
        ])->execute();
    }

    public function updateUser($id)
    {
        $user = Usuarios::findOne($id);
        if (!$user) {
            return false;
        }

        $user->rol = $this->rol;
        $user->fecha_nacimiento = $this->fecha_nacimiento;
        $user->celula = $this->celula;
        $user->fecha_ingreso = $this->fecha_ingreso;
        $user->fecha_graduacion = $this->fecha_graduacion;
        $user->foto = $this->foto;
        $user->color = $this->color;
        $user->status = $this->status;
        $user->updated_at = time();

        if (!empty($this->password) && $this->change_password) {
            $user->password_hash = Yii::$app->security->generatePasswordHash($this->password);
        }

        if ($user->validate() && $user->save()) {
            // Update phones
            Telefonos::deleteAll(['usuario' => $user->id]);
            foreach ($this->telefonos as $numero) {
                $telefono = new Telefonos();
                $telefono->usuario = $user->id;
                $telefono->telefono = $numero;
                $telefono->save();
            }

            // Re-assign roles
            $this->assignRole($user->id);
            return true;
        }

        return false;
    }

    public function getFechaFormateada($attribute) {
        setlocale(LC_TIME, 'es_ES.UTF-8');
        switch($attribute) {
            case 'fecha_nacimiento':
                if ($this->fecha_nacimiento) {
                    $timestamp = strtotime($this->fecha_nacimiento);
                    return strftime('%d de %B de %Y', $timestamp);
                }
            case 'fecha_ingreso':
                if ($this->fecha_ingreso) {
                    $timestamp = strtotime($this->fecha_ingreso);
                    return strftime('%d de %B de %Y', $timestamp);
                }
            case 'fecha_graduacion':
                if ($this->fecha_graduacion) {
                    $timestamp = strtotime($this->fecha_graduacion);
                    return strftime('%d de %B de %Y', $timestamp);
                }
        }
        return 'Fecha sin definir';
    }

    public function setScenario($scenario) {
        $this->scenario = $scenario;
    }

}
