<?php session_start();?>
<?php
/**
 * @version 1.0
 */

require("class.phpmailer.php");
require("class.smtp.php");
require("auto.php");

date_default_timezone_set('Etc/UTC');

$mail = new PHPMailer();
//indico a la clase que use SMPT
$mail->IsSMTP();
//indico el puerto que usa Gmail
$mail->Host = "localhost"; 
//indico el puerto que usa gmail
$mail->Port = 25;
$mail->SMTPAuth = true; 
//Debo de hacer autenticacion SMTP
//$mail->SMTPSecure = 'ssl';

$mail->IsHTML(true); 
$mail->CharSet = "utf-8";
//Permite modo debug para ver mensajes de las cosas que van ocurriendo
$mail->SMTPDebug=4;

// Valores enviados desde el formulario
/*if ( !isset($_POST["name"]) || !isset($_POST["email"]) || !isset($_POST["subject"]) ) {
    die ("Es necesario completar todos los datos del formulario");
}*/
$nombre = $_POST["name"];
$email = $_POST["email"];
$titulo = $_POST["subject"];
$mensaje = $_POST["message"];

// Datos de la cuenta de correo utilizada para enviar vía SMTP
//$smtpHost = "mail.anikout.com";  // Dominio alternativo brindado en el email de alta 
$smtpUsuario = "avisos@anikout.com";  // Mi cuenta de correo
$smtpClave = "Arte2018sana";  // Mi contraseña

// Email donde se enviaran los datos cargados en el formulario de contacto
$emailDestino = "ruizgerezr@gmail.com";
 
$mail->Username = $smtpUsuario; 
$mail->Password = $smtpClave;

$mail->From= $smtpUsuario; // Email desde donde envío el correo.
$mail->FromName = $nombre;
$mail->AddReplyTo($smtpUsuario, 'nombre'); // Esto es para que al recibir el correo y poner Responder, lo haga a la cuenta del visitante. 
$mail->Subject = $titulo; // Este es el titulo del email.
$mail->MsgHTML($mensaje);
$mail->Body = "{$mensajeHtml} <br /><br />Formulario enviado desde el Sitio de Carlos Fiotto e Hijos<br />"; // Texto del email en formato HTML
$mail->AltBody = "{$mensaje} \n\n Formulario enviado desde el Sitio de Carlos Fiotto e Hijos"; // Texto sin formato HTML

$mail->AddAddress($emailDestino,"NOmbre para"); // Esta es la dirección a donde enviamos los datos del formulario
// FIN - VALORES A MODIFICAR //

$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
echo !extension_loaded('openssl')?"Not Available":"Available";
if(!$mail->send()){
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message sent!';
}

