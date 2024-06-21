<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email;
    public $nombre;
    public $token;
    
    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion() {

         // create a new object
         $mail = new PHPMailer();
         $mail->isSMTP();
         $mail->Host = $_ENV['EMAIL_HOST'];
         $mail->SMTPAuth = true;
         $mail->Port = $_ENV['EMAIL_PORT'];
         $mail->Username = $_ENV['EMAIL_USER'];
         $mail->Password = $_ENV['EMAIL_PASS'];
     
         $mail->setFrom('arbitrosdeportistascartuja@gmail.com');
         $mail->addAddress($this->email, $this->nombre);
         $mail->Subject = 'CONFIRMAR CUENTA EN ÁRBITROS Y ÁRBITRAS DEPORTISTAS DE CARTUJA';

         // Set HTML
         $mail->isHTML(TRUE);
         $mail->CharSet = 'UTF-8';

         $contenido = '<html><body>'; // Abre el cuerpo del HTML
         $contenido .= "<p>¡Hola<strong> " . $this->nombre .  "</strong>!<br><br>Has registrado correctamente tu cuenta en la aplicación. Ahora, es necesario confirmarla.</p>";
         $contenido .= "<p>Para hacerlo, presiona en el siguiente enlace: <a href='" . $_ENV['HOST'] . "/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a>. Si tu no creaste esta cuenta, puedes ignorar este mensaje</p>";       
         $contenido .= "<p>Nos vemos en Cartuja.</p>";
         $contenido .= "<p>Un saludo,</p>";
         $contenido .= "<p>Organización del Grupo de Árbitros y Árbitras Deportistas de Cartuja.</p>";
         $contenido .= '</body></html>'; // Cierra el cuerpo y el HTML
         $mail->Body = $contenido;

         //Enviar el mail
         $mail->send();

    }

    public function enviarInstrucciones() {

        // create a new object
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
    
        $mail->setFrom('arbitrosdeportistascartuja@gmail.com');
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'REESTABLECER CONTRASEÑA';

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html><body>'; // Abre el cuerpo del HTML
        $contenido .= "<p>¡Hola<strong> " . $this->nombre .  "</strong>!<br><br>Has solicitado reestablecer tu contraseña, sigue el siguiente enlace para hacerlo.</p>";
        $contenido .= "<p>Presiona aquí: <a href='" . $_ENV['HOST'] . "/reestablecer?token=" . $this->token . "'>Reestablecer Password</a>";        
        $contenido .= "<p>Si tu no solicitaste este cambio, puedes ignorar este mensaje</p>";
        $contenido .= "<p>Nos vemos en Cartuja.</p>";
        $contenido .= "<p>Un saludo,</p>";
        $contenido .= "<p>Organización del Grupo de Árbitros y Árbitras Deportistas de Cartuja.</p>";
        $contenido .= '</body></html>'; // Cierra el cuerpo y el HTML
        $mail->Body = $contenido;

        //Enviar el mail
        $mail->send();
    }
}