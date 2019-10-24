<!DOCTYPE html>
<html>
<head>
  <!-- SITE TITLE -->
  <meta charset="utf-8">
  <title>Carlos A. Fiotto & Hijos SRL</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <meta name="description" content="Carlos A. Fiotto e Hijos SRL: Está al servicio de grandes empresas y también de aquellas que recién comienzan a operar en comercio exterior, 
  Carlos A. Fiotto e Hijos SRL Brinda un SERVICIO INTEGRAL que abarca todas las áreas del comercio exterior, sin excepción. De este modo, el cliente puede centralizar su requerimiento de importación y exportación, delegando la operatoria en una estructura profesional y eficiente.">
  
  <!-- CSS STYLE -->

  
  <!-- FAVICON -->
  <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
  <!-- MOBILE ICON -->
  <link rel="apple-touch-icon" href="img/webclip.png">
  </head>

<body>
  <?php session_start();?>
  <?php include('layout/header.php') ?>
  <div id="overlay"></div>
  <span id="image-loader">
    <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
  </span>

  <!-- SUB BANNER -->
  <div class="sub-banner">
    <div class="w-container">
      <div class="w-row">
        <div class="w-col w-col-6">
          <h4 class="title-bread">Contactanos&nbsp;<span class="sub-title-lighter">/ TEL: <a href="tel:5218-6655">5218-6655</a></span></h4>
        </div>
        <div class="w-col w-col-6 col-right">
          <div class="breadcrumbs">Inicio&nbsp;/&nbsp;Contacto</div>
        </div>
      </div>
    </div>
  </div>
  <!-- END SUB BANNER -->
  
  <!-- START SECTION 1 -->
  <section class="w-section section">
    <div class="w-container">
      <div class="w-row">
        <div class="w-col w-col-8">
          <div>
            <div>
              <form action="contactoEnvio.php" id="email-form" name="email-form" method="POST" data-name="Email Form">
                <input class="w-input text-field" id="contactName" type="text" placeholder="Nombre y Apellido" name="name" data-name="Name" required>
                <input class="w-input text-field" id="contactEmail" type="email" name="email" placeholder="Dirección de email" data-name="Email" required>
                <input class="w-input text-field" id="contactSubject" type="text" name="subject" placeholder="Asunto" data-name="Subject" required>
                <textarea class="w-input text-area" id="contactMessage" name="message" placeholder="Escribí tu mensaje..." data-name="Text Area" required></textarea>
                <div class="div-spc">
                  <button class="w-button button no-margin" type="submit">Enviar Mensaje</button>
                </div>
              </form>
              <div id="resultado-envio">
                <!-- contact-success -->
                    <?php if (isset($_SESSION["mensajeEnvio"])) 
                    {
                      echo '<i class="fa fa-check"></i> ' . $_SESSION["mensajeEnvio"];
                    }
                      session_destroy();
                    ?>
              </div>
            </div>
          </div>
        </div>
        <div class="w-col w-col-4">
          <div>
            <!--div class="w-widget w-widget-map" data-widget-latlng="-34.602724200,-58.376739800" data-widget-style="roadmap" data-widget-zoom="12"></div-->
            <div id="map">

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- END SECTION 1 -->
  

  
  <!-- JQUERY SCRIPTS -->

</body>
</html>