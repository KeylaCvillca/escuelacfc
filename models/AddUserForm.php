<?php
namespace app\models;

use yii\base\Model;
use yii\helpers\Security;
use Yii;
use app\models\User;

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

    public function rules()
    {
        return [
            [['username', 'email', 'password', 'created_at', 'updated_at'], 'required'],
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
        ];
    }

    public function addUser()
    {
        if ($this->validate()) {
            $user = new Usuarios();
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
            $user->password_hash = User::generateHash($this->password);
            $user->auth_key = Yii::$app->security->generateRandomString(); 
            $user->status = 10; 
            

            if ($user->save()) {
                foreach ($this->telefonos as $numero) {
                    $telefono = new Telefonos();
                    $telefono->usuario = $user->id;
                    $telefono->telefono = $this->$numero;
                    $telefono->save();
                }
                $user->created_at = time();
                $user->updated_at = time();
                return true;
            }
        }

        return null;
    }
}
