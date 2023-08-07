<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion(){

        // Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV["EMAIL_HOST"];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV["EMAIL_PORT"];
        $mail->Username = $_ENV["EMAIL_USER"];
        $mail->Password = $_ENV["EMAIL_PASS"];

        $mail->setFrom("cuentas@appsalon.com");
        $mail->addAddress("cuentas@appsalon.com", "AppSalon.com");
        $mail->Subject = "Confirma tu cuenta";

        $mail->isHTML(TRUE);
        $mail->CharSet = "UTF-8";
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola, " . $this->nombre . "</strong> Has creado tu cuenta. Sólo debes confirmarla</p>";
        $contenido .= "<a href='" . $_ENV["APP_URL"] . "/confirmar-cuenta?token=". $this->token . "'> aquí </a>";
        $contenido .= "</html>";

        $mail->Body = $contenido;
        $mail->send();
    }

    public function enviarInstrucciones(){

        // Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV["EMAIL_HOST"];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV["EMAIL_PORT"];
        $mail->Username = $_ENV["EMAIL_USER"];
        $mail->Password = $_ENV["EMAIL_PASS"];

        $mail->setFrom("cuentas@appsalon.com");
        $mail->addAddress("cuentas@appsalon.com", "AppSalon.com");
        $mail->Subject = "Reestablece tu Contraseña";

        $mail->isHTML(TRUE);
        $mail->CharSet = "UTF-8";
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola, " . $this->nombre . "</strong> Has solicitado reestablecer tu Contraseña. Puedes hacerlo</p>";
        $contenido .= "<a href='" . $_ENV["APP_URL"] . "/recuperar?token=". $this->token . "'> aquí </a>";
        $contenido .= "</html>";

        $mail->Body = $contenido;
        $mail->send();
    }
}