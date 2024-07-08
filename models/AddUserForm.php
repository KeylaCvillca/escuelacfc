<?php
namespace app\models;

use yii\base\Model;
use yii\helpers\Security;
use Yii;

class AddUserForm extends Model
{
    public $nombre_apellidos;
    public $id;
    public $rol;
    public $fecha_nacimiento;
    public $celula;
    public $fecha_ingreso;
    public $fecha_graduacion;
    public $email;
    public $password;
    public $foto;

    public function rules()
    {
        return [
            [['nombre_apellidos', 'email', 'password'], 'required'],
            ['email', 'email'],
            [['fecha_nacimiento', 'fecha_ingreso', 'fecha_graduacion'], 'date', 'format' => 'php:Y-m-d'],
            [['rol', 'celula'], 'string'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function attributeLabels()
    {
        return [
            'nombre_apellidos' => 'Nombre y Apellidos',
            'id' => 'ID',
            'rol' => 'Rol',
            'fecha_nacimiento' => 'Fecha de Nacimiento',
            'celula' => 'Célula',
            'fecha_ingreso' => 'Fecha de Ingreso',
            'fecha_graduacion' => 'Fecha de Graduación',
            'email' => 'Correo Electrónico',
            'password' => 'Contraseña',
            'foto' => 'Foto',
        ];
    }

    public function addUser()
    {
        if ($this->validate()) {
            $user = new Usuarios();
            $user->nombre_apellidos = $this->nombre_apellidos;
            $user->id = $this->id;
            $user->rol = $this->rol;
            $user->fecha_nacimiento = $this->fecha_nacimiento;
            $user->celula = $this->celula;
            $user->fecha_ingreso = $this->fecha_ingreso;
            $user->fecha_graduacion = $this->fecha_graduacion;
            $user->email = $this->email;
            $user->hash = Yii::$app->getSecurity()->generatePasswordHash($this->password);
            $user->foto = $this->foto;
            return $user->save();
        }
        return false;
    }
}
