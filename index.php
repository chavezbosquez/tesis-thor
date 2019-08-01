<?php
  session_start();
  if ( (isset($_SESSION['login'])) && ($_SESSION['login'] != '') ) {
    header("location: inicio.php");
  } else  //Mostrar errores de validación de usuario, en caso de que lleguen
    if( isset( $_POST['error'] ) ) {
      $clave  = $_POST['clave'];
      $contra = $_POST['contra'];
    }
    include_once "php/header.php";
?>
<!--
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Verano de Código 2019">
  <title>Sistema THOR 2019</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
    integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
    integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
  <link rel="stylesheet" href="css/estylo.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="js/bootbox.min.js"></script>
  <script src="js/bootbox.locales.min.js"></script>
</head>

<body role="document">
  <header>
    <div class="jumbotron display-4 text-white rounded-0">
      <div class="container pull-left">
        <img class="img-fluid" src="img/banner.png">
      </div>
    </div>
  </header>
  -->

  <main role="main" class="card container container-fluid body-content rounded p-4">
    <div class="row">
      <div class="col-xs-12 col-sm-10 col-md-3 col-lg-3 col-sm-offset-1 col-md-offset-1 col-lg-offset-1">
        <h2><i class="fas fa-lock"></i> Acceso</h2>
        <form id="contenido" name="login" method="post" action="php/login.php" role="form">
          <div class="form-group">
            <label class="control-label" for="clave">Nombre de usuario</label>
            <input class="form-control" data-val="true" data-val-required="Nombre de usuario es obligatorio."
                  id="clave" name="clave" type="text" autofocus required value="<?php echo (isset($clave)) ? $clave : ''; ?>">
            <span class="field-validation-valid text-danger" data-valmsg-for="clave" data-valmsg-replace="true"></span>
          </div>
          <div class="form-group">
            <label class="control-label" for="contra">Contrase&#241;a</label>
            <input autocomplete="off" class="form-control" data-val="true" data-val-required="Contraseña obligatoria."
                  id="contra" name="contra" type="password" required value="<?php echo (isset($contra)) ? $contra : ''; ?>">
            <span class="field-validation-valid text-danger" data-valmsg-for="contra"
                  data-valmsg-replace="true"></span>
          </div>
          <div class="form-group">
            <button class="btn btn-primary btn-block" type="submit">Ingresar</button>
          </div>
        </form>
        </div>
        <div class="col-xs-12 col-sm-10 col-md-8 col-lg-8 col-sm-offset-1 col-md-offset-0 col-lg-offset-1" style="margin-left: 40px; margin-top: 20px;">
          <h1>
          <i class="fas fa-hammer"></i>
            Sistema THOR
            <code class="font-italic" style="font-size: 0.5em">THesis Online Repository</code>
          </h1>
          <hr>
          <p class="text-justify lead">El <strong>Sistema THOR</strong> fue desarollado durante el Verano de Código 2019 por un 
            <a href="acercade.php">entusiasta equipo de programadores</a> en conjunto con la Coordinación de Estudios Terminales.
          </p>
          <p class="lead">
            Si deseas puedes ingresar a nuestra plataforma y consultar:
          </p>
          <div class="row">
            <div class="col-2 mx-auto"></div>
            <a class="btn btn-warning col-3 mx-auto" href="ver-profesores.php">
                <i class="lead fas fa-users"></i>
                <span class="lead">Profesores</span>
            </a>
            <a class="btn btn-success col-3 mx-auto" href="formatos.php">
                <i class="lead far fa-file"></i>
                <span class="lead">Formatos</span>
              </a>
              <div class="col-2 mx-auto"></div>
          </div>
          <p>&nbsp;</p>
      </div>
    </div>
  </main>
  <footer class="footer bg-success fixed-bottom">
    <p class="container pull-left small text-white"> Versión 2019.01 &nbsp; | &nbsp; División Académica de Informática y Sistemas</p>
  </footer>
  <?php if (isset($_POST['error'])) { // Validación de credenciales correctas ?>
    <script>
      bootbox.alert("<h3>Acceso denegado</h3>Credenciales de acceso incorrectas.");
    </script>
  <?php } ?>
</body>

</html>
