<?php
namespace app\models;

use yii\base\Model;
use Yii;

class MisDatosForm extends Model
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
            [['username', 'email', 'password'], 'required'],
            [['fecha_nacimiento', 'fecha_ingreso', 'fecha_graduacion'], 'safe'],
            [['nombre_apellidos'], 'string', 'max' => 50],
            [['rol'], 'string', 'max' => 40],
            [['celula'], 'string', 'max' => 20],
            [['foto', 'username', 'password', 'email'], 'string', 'max' => 255],
            [['color'], 'string', 'max' => 15],
            [['email'], 'email'],
            [['email', 'username'], 'unique', 'targetClass' => User::class],
            [['color'], 'exist', 'skipOnError' => true, 'targetClass' => Niveles::class, 'targetAttribute' => ['color' => 'color']],
        ];
    }
    
    public function __construct($user, $config = [])
    {
        parent::__construct($config);
        $this->username = $user->username;
        $this->email = $user->email;
        $this->nombre_apellidos = $user->nombre_apellidos;
        $this->rol = $user->rol;
        $this->fecha_nacimiento = $user->fecha_nacimiento;
        $this->celula = $user->celula;
        $this->fecha_ingreso = $user->fecha_ingreso;
        $this->fecha_graduacion = $user->fecha_graduacion;
        $this->foto = $user->foto;
        $this->color = $user->color;
        $this->pais = $user->pais;
    }
}
