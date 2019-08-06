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
	$folio   = $_POST['folio'];
  $estatus = $_POST['estatus'];
  
  $hoy = date("y/m/d", time());
  $pdo = BaseDeDatos::conectar();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $directorio = "docs/" . $folio . "/";

  /* Dependiendo del estatus se guardarán diferentes archivos */
  if ($estatus == "F7") {
    /* Guardar los oficios del Jurado */
    Archivo::errorArchivo("archivo1");
    Archivo::errorArchivo("archivo2");
    Archivo::errorArchivo("archivo3");
    Archivo::errorArchivo("archivo4");
    Archivo::errorArchivo("archivo5");

    $nombreArchivo1 = $folio . "-JURADO1.pdf";
    $_FILES["archivo1"]["name"] = $nombreArchivo1;
    $nombreArchivo2 = $folio . "-JURADO2.pdf";
    $_FILES["archivo2"]["name"] = $nombreArchivo2;
    $nombreArchivo3 = $folio . "-JURADO3.pdf";
    $_FILES["archivo3"]["name"] = $nombreArchivo3;
    $nombreArchivo4 = $folio . "-JURADO4.pdf";
    $_FILES["archivo4"]["name"] = $nombreArchivo4;
    $nombreArchivo5 = $folio . "-JURADO5.pdf";
    $_FILES["archivo5"]["name"] = $nombreArchivo5;
    Archivo::cargarArchivo("archivo1",$directorio);
    Archivo::cargarArchivo("archivo2",$directorio);
    Archivo::cargarArchivo("archivo3",$directorio);
    Archivo::cargarArchivo("archivo4",$directorio);
    Archivo::cargarArchivo("archivo5",$directorio);
    
    /****************************** INSERTAR DATOS *****************************/
    
    /* Guardar datos del F8 */
    $sql = "UPDATE tesis SET estatus='F8-A' WHERE folio='{$folio}'";
    $cons = $pdo->prepare($sql);
    $cons->execute();

    /* Guardar los documentos */
    $sql = "INSERT INTO documento(tipo_documento,nombre_archivo,tesis,fecha) VALUES(?,?,?,?)";
    $cons = $pdo->prepare($sql);
    $cons->execute( array("JURADO1",$nombreArchivo1,$folio,$hoy) );
    $cons->execute( array("JURADO2",$nombreArchivo2,$folio,$hoy) );
    $cons->execute( array("JURADO3",$nombreArchivo3,$folio,$hoy) );
    $cons->execute( array("JURADO4",$nombreArchivo4,$folio,$hoy) );
    $cons->execute( array("JURADO5",$nombreArchivo5,$folio,$hoy) );
  
    /* Bitácora del Sistema */
    date_default_timezone_set("America/Mexico_City");
    $hoy = date("Y-m-d H:i:s");
    $sql = "INSERT INTO bitacora(tesis,operacion,fecha,usuario) VALUES(?,?,?,?)";
    $cons = $pdo->prepare($sql);
    $cons->execute( array($folio,"Registro del Jurado",$hoy,$usuario) );

  } else if ($estatus == "F8-A") {
    /* Guardar el F8 */
    $fecha = $_POST['fecha'];

    Archivo::errorArchivo("archivo6");

    $nombreArchivo6 = $folio . "-F8.pdf";
    $_FILES["archivo6"]["name"] = $nombreArchivo6;
    Archivo::cargarArchivo("archivo6",$directorio);
    
    /****************************** INSERTAR DATOS *****************************/
    /* Guardar datos del F8 */
    $sql = "UPDATE tesis SET estatus='F8' WHERE folio='{$folio}'";
    $cons = $pdo->prepare($sql);
    $cons->execute();

    /* Guardar el documento */
    $sql = "INSERT INTO documento(tipo_documento,nombre_archivo,tesis,fecha) VALUES(?,?,?,?)";
    $cons = $pdo->prepare($sql);
    $cons->execute( array("F8",$nombreArchivo6,$folio,$fecha) );
    
    /* Bitácora del Sistema */
    date_default_timezone_set("America/Mexico_City");
    $hoy = date("Y-m-d H:i:s");
    $sql = "INSERT INTO bitacora(tesis,operacion,fecha,usuario) VALUES(?,?,?,?)";
    $cons = $pdo->prepare($sql);
    $cons->execute( array($folio,"Registro del F8",$hoy,$usuario) );

  } else {
    die("Error de estatus.");
  }

  BaseDeDatos::desconectar();
  header("Location: ver-tesis.php?f=8");
?>