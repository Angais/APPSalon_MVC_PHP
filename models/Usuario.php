<?php

namespace Model;

class Usuario extends ActiveRecord{
    // Base de datos
    protected static $tabla = "usuarios";
    protected static $columnasDB = ["id", "nombre", "apellido", "email", "password", "telefono", "admin", "confirmado", "token"];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->nombre = $args["nombre"] ?? "";
        $this->apellido = $args["apellido"] ?? "";
        $this->email = $args["email"] ?? "";
        $this->password = $args["password"] ?? "";
        $this->telefono = $args["telefono"] ?? "";
        $this->admin = $args["admin"] ?? 0;
        $this->confirmado = $args["confirmado"] ?? 0;
        $this->token = $args["token"] ?? "";
    }

    // Mensajes de Validación
    public function validarNuevaCuenta(){
        if(!$this->nombre){
            self::$alertas["error"][] = "Añada un nombre";
        }
        if(!$this->apellido){
            self::$alertas["error"][] = "Añada un apellido";
        }
        if(!$this->email){
            self::$alertas["error"][] = "Añada una dirección de Correo Electrónico";
        }
        if(!$this->password){
            self::$alertas["error"][] = "Añada una Contraseña";
        }
        if(strlen($this->password) < 6 && $this->password){
            self::$alertas["error"][] = "La Contraseña debe tener mínimo 6 caracteres";
        }

        return self::$alertas;
    }

    public function validarLogin(){
        if(!$this->email){
            self::$alertas["error"][] = "Escriba su dirección de Correo Electrónico";
        }
        if(!$this->password){
            self::$alertas["error"][] = "Escriba su Contraseña";
        }

        return self::$alertas;
    }

    public function validarEmail(){
        if(!$this->email){
            self::$alertas["error"][] = "Escriba su dirección de Correo Electrónico";
        }

        return self::$alertas;
    }

    public function validarPassword(){
        if(!$this->password){
            self::$alertas["error"][] = "Escriba una Contraseña";
        }
        if(strlen($this->password) < 6){
            self::$alertas["error"][] = "La Contraseña debe contener mínimo 6 caracteres";
        }

        return self::$alertas;
    }
    
    // Revisa si el usuario existe
    public function existeUsuario(){
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
        $resultado = self::$db->query($query);
        
        if($resultado->num_rows){
            self::$alertas["error"][] = "Este Correo Electrónico ya está siendo usado";
        }

        return $resultado;
    }

    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken(){
        $this->token = uniqid();
    }

    public function comprobarPasswordAndVerificado($password){
        $resultado = password_verify($password, $this->password);

        if(!$resultado){
            self::$alertas["error"][] = "Contraseña Incorrecta";
            return false;
        } else{
            if(!$this->confirmado){
                self::$alertas["error"][] = "El Usuario no está verificado";
                return false;
            } else{
                return true;
            }
        }


    }

}