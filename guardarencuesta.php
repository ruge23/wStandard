<?php
error_reporting(E_ALL ^ E_WARNING); 
//http://stackoverflow.com/questions/18382740/cors-not-working-php
if (isset($_SERVER['HTTP_ORIGIN'])) {
  header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
  header('Access-Control-Allow-Credentials: true');
  header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
    header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

  exit(0);
}


//http://stackoverflow.com/questions/15485354/angular-http-post-to-php-and-undefined
include("envioMail/class.phpmailer.php");
include("envioMail/class.smtp.php");
include("envioMail/auto.php");
$postdata = file_get_contents("php://input");
if (isset($postdata)) {
  $request = json_decode($postdata);
  $nombreYapellido = $request->nombreYapellido;
  $email = $request->mail;
  $ciudad = $request->ciudad;
  $provincia = $request->provincia;
  $moto = $request->moto;
  $productoMP = $request->productoMP;

  $conn = conectar();
  $sql6 = "SELECT * FROM encuesta e inner join codigo c on e.encuestaid = c.usuarioid where e.mail = '$email';";

  $resultado6=mysqli_query($conn,$sql6);

  if (mysqli_num_rows($resultado6) == 0) {

    //return $conn;
    $sql = "INSERT INTO encuesta (nombreyapellido,mail,ciudad,provincia,moto,productomp,fecha)
    VALUES ('$nombreYapellido','$email','$ciudad','$provincia','$moto','$productoMP', NOW());";

    $resultado=mysqli_query($conn,$sql);
    $lastid = mysqli_insert_id($conn);
    //echo $lastid;
    $sql2 = "SELECT * FROM codigo WHERE usado = 0 LIMIT 1;";
    //echo "id" . $lastid . " - sql: " . $sql2;
    $resultado2=mysqli_query($conn,$sql2);
    $row2 = mysqli_fetch_array($resultado2);
    $codigo = $row2["codigo"];
    $codigoid = $row2["codigoid"];
    //echo "codig".$codigoid;
    $sql3 = "UPDATE codigo SET usado = 1, usuarioid = '$lastid' WHERE codigoid = '$codigoid';";

    $resultado3=mysqli_query($conn,$sql3);
    
    delivery_response(200, "event created", strip_tags($codigo,'\t'));

    $mail = new PHPMailer();
    $mail->isSMTP();

    $smtpHost = "smtp.gmail.com";
    $mail->Host = $smtpHost;
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->isHTML(true);
    $mail->CharSet = "utf-8";

    $smtpUsuario = "atencion@wstandard.com.ar";
    $smtpClave = "aTwSt4nrd!";

    $emailDestino = $email;
    //echo "email" . $email . "email";
    $mail->Username = $smtpUsuario;
    $mail->Password = $smtpClave;
    $mail->From = $smtpUsuario;
    $mail->FromName = "WStandard";
    $mail->addReplyTo($smtpUsuario, 'WStandard');
    $mail->Subject = "Codigo descuento - WStandard!";
    $mail->Body = '
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>WSTANDARD GROUP | CODIGO DE DESCUENTO PARA COMPRA EN MERCADO LIBRE</title>
<style>
/* Basics */
body {
    margin: 0;
    padding: 0;
    min-width: 100%;
    background-color: #ffffff;
}

table {
    border-spacing: 0;
    font-family: sans-serif;
    color: #333333;
    width: 600px;
}
#tabla{
    width: 600px;
}

td {
    padding: 0;
}
img {
    border: 0;
}

/* Windows Phone Viewport Fix */
/*@-ms-viewport { 
    width: device-width; 
}*/

.full-width-image img {
    width: 100%;
    height: auto;
}

a {
    color: #ee6a56;
    text-decoration: none;
}
h1 {
    font-size: 26px;
    font-weight: normal;
    margin: 30px 0px;
}
h2 {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 12px;
}

.cols-30{
    width: 30%;
        padding: 0px 0px;
}
.cols-30 p{
    font-size: 12px;
    margin: 0px 0px;
}
.cols-30 h3{
    font-size: 14px;
}
.content-precios{
    background-color: #e8e8e8;
    width: 80%;
    margin: 0px auto;
    margin-bottom: 30px;
    padding: 20px;
}

.cols-50{
    width: 50%;
}

.cols-auto{
    width: auto;
}

.cols-50 .text{
    text-align: left;
}
.cols-50 .button{
    text-align: left;
}

.cols-70{
    width: 70%;
}

.img-tabla{
    width: 65%;
    height: auto;
}
.cinta{
    float: right;
    width: auto;
    padding-bottom:20px;
    padding-top:22px;
    padding-right:20px;
}

.img-desktop{
    display: block;
}
.img-mobile{
    display: none;
}
/*Media Queries*/
@media screen and (max-width: 400px) {
    h1 {
        font-size: 16px;
        margin: 20px 0px;
    }
    table{
        width: 100%;
    }
    #tabla{
        width: 100%;
    }
    /*.cols-30{
        width: 100%;padding: 0px 30px;
    }*/
    .cols-30{
        width: 100%;
        display: block;
    }
    .cols-50{
        width: 100%;
        display: block;
        border-collapse:collapse;
    }
    .cols-auto{
        width: 100%;
        display: block;
        border-collapse:collapse;
    }
    .cols-50 .text{
        text-align: left;
    }
    .cols-50 .button{
        text-align: center;
    }
    .cols-70{
        width: 100%;
        display: block;
        border-collapse:collapse;
    }
    .img-tabla{
        width: 90%;
        height: auto;
    }
    .cinta{
        width: auto;
    }
    .img-desktop{
    display: none;
    }
    .img-mobile{
        display: block;
    }
}

@media screen and (min-width: 401px) and (max-width: 620px) {
    #tabla{
        width: 100%;
    }
    table{
        width: 100%;
    }
    h1 {
        font-size: 20px;
        /*margin: 20px 0px;*/
    }
    .img-tabla{
        width: 90%;
        height: auto;
    }
    .cols-30{
        width: 100%;
        display: block;
    }    
    .cols-50{
        width: 100%;
        display: block;
        border-collapse:collapse;
    }
    .cols-auto{
        width: 100%;
        display: block;
        border-collapse:collapse;
    }    
    .cols-50 .text{
        text-align: left;
    }
    .cols-50 .button{
        text-align: center;
    }
    .cols-70{
        width: 100%;
        display: block;
        border-collapse:collapse;
    }
    .img-desktop{
    display: none;
    }
    .img-mobile{
        display: block;
    }
}
@media screen and (max-width: 320px){
    .img-tabla{
        width: 90%;
        height: auto;
    }
    .cols-30{
        width: 100%;
        display: block;
    }    
    .cols-50{
        width: 100%;
        display: block;
        border-collapse:collapse;
    }
    .cols-auto{
        width: 100%;
        display: block;
        border-collapse:collapse;
    }    
    .cols-50 .text{
        text-align: left;
    }
    .cols-50 .button{
        text-align: center;
    }
    .cols-70{
        width: 100%;
        display: block;
        border-collapse:collapse;
    }
    .img-desktop{
    display: none;
    }
    .img-mobile{
        display: block;
    }
}

</style>
<!--[if (gte mso 9)|(IE)]>
<style type="text/css">
    table {border-collapse: collapse;}
</style>
<![endif]-->
</head>
<body>
<center class="wrapper">
          <table id="tabla" align="center" cellpadding="0" cellspacing="0">
                <!-- logo y linkedin-->
                <tr>
                    <td colspan="3"><a href="https://www.wstandard.com.ar" target="blank"><img style="padding-top:20px; padding-left:28px; text-align:left; padding-bottom:20px;" src="http://wstandard.com.ar/codigos-desc-meli/envioMail/images/LOGO-WSG-MAILING-CODIGO.png" alt="WSTANDARD GROUP" width="auto"/></a>
                    </td>
                </tr>
                <!-- Texto -->
                <tr>
                  <td colspan="3">
                    <table id="Primer_texto" style="width:100%; height:auto; background-color:#ffe324;" align="center">
                      <tr>
                          <td>
                          <p style="font-family: \'Trebuchet MS\', Arial, sans-serif;font-size: 14px; line-height:16px; padding-left: 50px; padding-right:50px; padding-top:40px; color: #3c3c3b; text-align:left; margin-block-start: 0px;">¡Felicidades! Ya podés utilizar el código de descuento en tu próxima compra:</p>                     
                          </td>
                      </tr>
                      
                      <tr>
                          <td>
                          <p style="font-family: \'Trebuchet MS\', Arial, sans-serif;font-size: 18px; line-height:21px; padding-left: 50px; padding-right:50px; color: #3c3c3b; text-align:left; margin-block-start: 0px;"><strong>' . $codigo . '</strong></p>                    
                          </td>
                      </tr>
                      <tr>
                          <td>
                          <p style="font-family: \'Trebuchet MS\', Arial, sans-serif;font-size: 14px; line-height:16px; padding-left: 50px; padding-right:50px; color: #3c3c3b; text-align:left; margin-block-start: 0px;">Podés utilizarlo solo para compras desde la app de Mercado Libre en cualquiera de nuestras tiendas oficiales</p>                       
                          </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <!-- 3 destacados -->
                <tr>
                  <td colspan="3">
                    <table id="links_a_tiendas" style="align:center; background-color:#ffe324; padding-top:15px; padding-left:20px; padding-right:20px;">
                      <tr>
                          <td class="cols-30" style="text-align:center; margin-bottom:0px;"><a href="https://tienda.mercadolibre.com.ar/wstandard" target="blank"><img src="http://wstandard.com.ar/codigos-desc-meli/envioMail/images/btn-WSG-2.png" alt="TIENDA OFICIAL WSTANDARD EN MERCADO LIBRE"/></a>
                          </td>
                        <td class="cols-30" style="text-align:center; margin-bottom:0px;"><a href="https://tienda.mercadolibre.com.ar/just-1" target="blank"><img src="http://wstandard.com.ar/codigos-desc-meli/envioMail/images/btnJ1-2.png" alt="TIENDA OFICIAL JUST1 EN MERCADO LIBRE"/></a>
                        </td>
                        <td class="cols-30" style="text-align:center; margin-bottom:0px;"><a href="https://tienda.mercadolibre.com.ar/onguard" target="blank"><img src="http://wstandard.com.ar/codigos-desc-meli/envioMail/images/btn-ONGUARD-2.png" alt="TIENDA OFICIAL ONGUARD EN MERCADO LIBRE"/></a>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <!-- texto final-->
                <tr>
                  <td colspan="3">
                    <table id="texto_final" style="width:100%; height:auto; background-color:#ffe324; padding-bottom:20px;" align="center">
                      <tr>
                          <td>
                          <p style="font-family: \'Trebuchet MS\', Arial, sans-serif;font-size: 14px; line-height:16px; padding-left: 50px; padding-right:50px; padding-top:40px; color: #3c3c3b; text-align:left; margin-block-start: 0px;"><i>¡Muchas Gracias! Y que disfrutes de tu próxima compra.</i><br><strong>El equipo de Wstandard Group</strong></p>                       
                          </td>
                      </tr>
                    </table>                                
                </td>
               </tr>
                <!-- footer-->
                <table>
                <tr style="background-color:#000"; >
                    <td colspan="3"><a href="https://www.wstandard.com.ar" target="blank"><p style="font-family: \'Trebuchet MS\', Arial, sans-serif;font-size: 11px; line-height:13px; padding-left: 40px; padding-right:40px; padding-top:40px; padding-bottom:20px; color: #fff; text-align:left; margin-block-start: 0px;">wstandard.com.ar</p></a>
                    </td>
                </tr>
                </table>
          </table>          
    </center>
</body>
</html>';

    $mail->AddAddress($emailDestino, $nombreYapellido);

    $mail->SMTPOptions = array(
      'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
      )
    );
    $resultadoMail = "";
    if(!$mail->send()){
      $resultadoMail = 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
      $resultadoMail = 'Message sent!';
    }
    //echo "Server returns: " . $username ."Server returns: " . $apellido ."Server returns: " . $idempleado;
  }
  else {
    delivery_response(200, "usuario repetido", false);
  }
}
else {
  echo "Not called properly with username parameter!";
}


function delivery_response($status, $status_message, $data)
{
  header("HTTP/1.1 $status $status_message");

  $response['status'] = $status;
  $response['status_message'] = $status_message;
  $response['data'] = $data;

  $json_response = json_encode($response);
  echo $json_response;
}

// function conectar(){
// 	$mysqli = new mysqli("localhost", "admintst_wsadmin", "Scorpio123", "admintst_ws");
// 	//$mysqli = new mysqli("localhost", "c0710367_arte", "Artesana123", "c0710367_arte");
// 	mysqli_set_charset($mysqli,"utf8");
// 	if($mysqli->connect_error) 
// 		die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
// 	return $mysqli;
// }

function conectar(){
	$mysqli = new mysqli("localhost", "melitesting_Ws", "g2ahC11~", "WSmeliTest");
	//$mysqli = new mysqli("localhost", "c0710367_arte", "Artesana123", "c0710367_arte");
	mysqli_set_charset($mysqli,"utf8");
	if($mysqli->connect_error)
		die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
	return $mysqli;
}

?>
