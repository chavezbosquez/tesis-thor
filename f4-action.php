<?php
  session_start();
  if ($_SESSION['login'] == '') {
    header("location: index.php");
  }
	if ( empty($_POST) ) {
    header("Location: inicio.php");
  }
  $usuario = $_SESSION['login'];
  
  require_once 'php/bd.php';
  require_once 'php/archivo.php';

  /* Datos generales */
  $folio         = $_POST['folio'];
  $fecha         = $_POST['fecha'];
  $hayCodirector =  $_POST['hayCodirector'];

  $pdo = BaseDeDatos::conectar();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  /* Guardar los oficios de la Comisión revisora */
  Archivo::errorArchivo("archivo1");
  Archivo::errorArchivo("archivo2");

  $directorio = "docs/" . $folio . "/";
  
  $nombreArchivo1 = $folio . "-F4.pdf";
  $_FILES["archivo1"]["name"] = $nombreArchivo1;
  $nombreArchivo2 = $folio . "-DIRECTOR1.pdf";
  $_FILES["archivo2"]["name"] = $nombreArchivo2;
  Archivo::cargarArchivo("archivo1",$directorio);
  Archivo::cargarArchivo("archivo2",$directorio);

  if ($hayCodirector) {
    Archivo::errorArchivo("archivo3");
    $nombreArchivo3 = $folio . "-DIRECTOR2.pdf";
    $_FILES["archivo3"]["name"] = $nombreArchivo3;
    Archivo::cargarArchivo("archivo3",$directorio);
  }
    
  /****************************** INSERTAR DATOS *****************************/
    
  /* Guardar datos del F4 */
  $sql = "UPDATE tesis SET estatus='F4' WHERE folio='{$folio}'";
  $cons = $pdo->prepare($sql);
  $cons->execute();

  /* Guardar los documentos */
  $sql = "INSERT INTO documento(tipo_documento,nombre_archivo,tesis,fecha) VALUES(?,?,?,?)";
  $cons = $pdo->prepare($sql);
  $cons->execute( array("F4",$nombreArchivo1,$folio,$fecha) );
  $cons->execute( array("DIRECTOR1",$nombreArchivo2,$folio,$fecha) );
  if ($hayCodirector) {
    $cons->execute( array("DIRECTOR2",$nombreArchivo3,$folio,$fecha) );
  }

  /* Bitácora del Sistema */
  date_default_timezone_set("America/Mexico_City");
  $hoy = date("Y-m-d H:i:s");
  $sql = "INSERT INTO bitacora(tesis,operacion,fecha,usuario) VALUES(?,?,?,?)";
  $cons = $pdo->prepare($sql);
  $cons->execute( array($folio,"Registro del F4",$hoy,$usuario) );

  BaseDeDatos::desconectar();
  header("Location: ver-tesis.php?f=4");
?>