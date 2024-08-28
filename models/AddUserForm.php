<?php

namespace app\models;

use yii\base\Model;
use Yii;
use app\models\Usuarios;
use app\models\Telefonos;
use app\models\Niveles;
use app\models\Ensenan;

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
    public $niveles = []; // Array to hold selected levels
    public $funcion = []; // Array to hold corresponding functions (titular or auxiliar)
    public $auth_key;
    public $password_hash;
    public $password_reset_token;
    public $scenario;
    public $fotoFile;
    
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
        

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
        $user = new Usuarios();
        
        // IMPORTANTE: Esta parte es necesaria para que $this->validate() sea true y pueda pasar a la siguiente fase.
        $nombrePart = substr(str_replace(' ', '', $this->nombre_apellidos), 0, 4);
        $celulaPart = substr($this->celula, 0, 3);           // First 3 letters of celula
        $datePart = date('dm');                              // Current day and month in 'ddmm' format
        $this->username = strtolower($nombrePart . $celulaPart . $datePart);
        // Hasta aquí.
        
        
        if ($this->validate()) {
            $user->attributes = $this->attributes;
            $user->password_hash = Yii::$app->security->generatePasswordHash($this->password);
            $user->auth_key = Yii::$app->security->generateRandomString();
            $user->status = 10; 
            $user->created_at = time();
            $user->updated_at = time();
            
            if ($user->save()) {
                // Save phones
                foreach ($this->telefonos as $numero) {
                    $telefono = new Telefonos();
                    $telefono->usuario_id = $user->id;
                    $telefono->telefono = $numero;
                    $telefono->save();
                }
                $this->assignRole($user->id);
                // Save teaching assignments if role is maestra
                if ($this->rol === 'maestra') {
                    foreach ($this->niveles as $key => $nivel) {
                        $ensenan = new Ensenan();
                        $ensenan->usuario_id = $user->id;
                        $ensenan->nivel_id = $nivel;
                        $ensenan->funcion = $this->funcion[$key];
                        $ensenan->save();
                    }
                }
                
                return true;
            }
        }

        return false;
    }
    
    /**
     * Método que asigna un rol dentro del RBAC al usuario que estamos creando o actualizando.
     * 
     * Importante para que el RBAC funcione de manera intuitiva.
     * 
     * @param type $userId
     */
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
        // Find the existing user by ID
        $user = Usuarios::findOne($id);
        if (!$user) {
            return false; // User not found
        }

        // Update user attributes with the form data
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
        $user->status = $this->status;
        $user->updated_at = time();

        // If the password was provided, update it
        if (!empty($this->password)) {
            $user->password_hash = Yii::$app->security->generatePasswordHash($this->password);
        }

        if ($this->validate() && $user->save()) {
            // Update phones
            Telefonos::deleteAll(['usuario' => $user->id]); // Clear existing phone numbers
            foreach ($this->telefonos as $numero) {
                $telefono = new Telefonos();
                $telefono->usuario_id = $user->id;
                $telefono->telefono = $numero;
                $telefono->save();
            }

            // Re-assign roles
            $this->assignRole($user->id);

            // Update teaching assignments if the role is "maestra"
            if ($this->rol === 'maestra') {
                Ensenan::deleteAll(['maestra' => $user->id]); // Clear existing teaching assignments
                foreach ($this->niveles as $key => $nivel) {
                    $ensenan = new Ensenan();
                    $ensenan->usuario_id = $user->id;
                    $ensenan->nivel_id = $nivel;
                    $ensenan->funcion = $this->funcion[$key];
                    $ensenan->save();
                }
            }

            return true;
        }

        return false;
    }

}
