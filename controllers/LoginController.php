<?php

namespace Controllers;
use MVC\Router;
use Model\Usuario;
use Classes\Email;

class LoginController{
    public static function login(Router $router){

        $alertas = [];
        $auth = new Usuario($_POST);

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();

            if(empty($alertas)){
                $usuario = Usuario::where("email", $auth->email);

                if($usuario){
                    if($usuario->comprobarPasswordAndVerificado($auth->password)){
                        session_start();

                        $_SESSION["id"] = $usuario->id;
                        $_SESSION["nombre"] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION["email"] = $usuario->email;
                        $_SESSION["login"] = true;

                        // Redireccionar
                        if($usuario->admin == 1){
                            $_SESSION["admin"] = $usuario->admin ?? null;
                            header("Location: /admin");
                        } else{
                            header("Location: /cita");
                        }
                    }
                } else{
                    Usuario::setAlerta("error", "El usuario no existe");
                }
            }

        }
        $alertas = Usuario::getAlertas();
        $router->render("auth/login", [
            "alertas" => $alertas,
            "auth" => $auth
        ]);
    }
    public static function logout(){
        session_start();
        $_SESSION = [];
        header("Location: /");
    }
    public static function olvide(Router $router){

        $alertas = [];

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if(empty($alertas)){
                $usuario = Usuario::where("email", $auth->email);

                if($usuario){
                    if($usuario->confirmado == "1"){
                        $usuario->crearToken();
                        $usuario->guardar();

                        // TO DO: Enviar Email

                        $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                        $email->enviarInstrucciones();

                        Usuario::setAlerta("exito", "Todo ha funcionado correctamente. Revisa tu bandeja de entrada");
                    }
                    else{
                        Usuario::setAlerta("error", "El Usuario no está verificado");
                    }
                }
                else{
                    Usuario::setAlerta("error", "El Usuario no existe");
                    $alertas = Usuario::getAlertas();
                }
            }
            $alertas = Usuario::getAlertas();
        }
        $router->render("auth/olvide-password", [
            "alertas" => $alertas
        ]);
    }
    public static function recuperar(Router $router){

        $alertas = [];
        $error = false;

        $token = s($_GET["token"]);
        $usuario = Usuario::where("token", $token);

        if(empty($usuario)){
            Usuario::setAlerta("error", "Token no válido");
            $error = true;
        }

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            // Leer y guardar nueva contraseña

            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();

            if(empty($alertas)){
                $usuario->password = null;

                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;
                $resultado = $usuario->guardar();

                if($resultado){
                    header("Location: /");
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render("auth/recuperar-password", [
            "alertas" => $alertas,
            "error" => $error
        ]);    }
    public static function crear(Router $router){
        $usuario = new Usuario;

        //Alertas vacías
        $alertas = [];
        if($_SERVER["REQUEST_METHOD"] === "POST"){

            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            // Revisar que alertas esté vacío

            if(empty($alertas)){
                $resultado = $usuario->existeUsuario();

                if($resultado->num_rows){
                    $alertas = Usuario::getAlertas();
                } else{
                    // No está registrado
                    $usuario->hashPassword();

                    // Generar token
                    $usuario->crearToken();

                    // Enviar Email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();

                    // Crear el usuario
                    $resultado = $usuario->guardar();
                    if($resultado){
                        header("Location: /mensaje");
                    }

                    //debuguear($email);
                }
            }
        }
        $router->render("auth/crear-cuenta", [
            'usuario' => $usuario,
            "alertas" => $alertas
        ]);
    }

    public static function mensaje(Router $router){
        $router->render("auth/mensaje");
    }

    public static function confirmar(Router $router){
        $alertas = [];

        $token = s($_GET["token"]);

        $usuario = Usuario::where("token", $token);

        if(empty($usuario)){
            // Error
            Usuario::setAlerta("error", "Token no válido");
        }
        else{
            // Verificar
            $usuario->confirmado = 1;
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta("exito", "Cuenta Confirmada");
        }
        $alertas = Usuario::getAlertas();
        $router->render("auth/confirmar-cuenta", [
            "alertas" => $alertas
        ]);
    }

}