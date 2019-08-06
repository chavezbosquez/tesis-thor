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

  $pdo = BaseDeDatos::conectar();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  /* Guardar el oficio */
  Archivo::errorArchivo("archivo");
  
  $directorio = "docs/" . $folio . "/";

  $nombreArchivo = $folio . "-F6.pdf";
  $_FILES["archivo"]["name"] = $nombreArchivo;
  Archivo::cargarArchivo("archivo",$directorio);

  /****************************** INSERTAR DATOS *****************************/
    
  /* Guardar datos del F6 */
  $sql = "UPDATE tesis SET estatus='F6' WHERE folio='{$folio}'";
  $cons = $pdo->prepare($sql);
  $cons->execute();

  /* Guardar el documento */
  $sql = "INSERT INTO documento(tipo_documento,nombre_archivo,tesis,fecha) VALUES(?,?,?,?)";
  $cons = $pdo->prepare($sql);
  $cons->execute( array("F6",$nombreArchivo,$folio,$fecha) );

  /* Bitácora del Sistema */
  date_default_timezone_set("America/Mexico_City");
  $hoy = date("Y-m-d H:i:s");
  $sql = "INSERT INTO bitacora(tesis,operacion,fecha,usuario) VALUES(?,?,?,?)";
  $cons = $pdo->prepare($sql);
  $cons->execute( array($folio,"Registro del F6",$hoy,$usuario) );

  BaseDeDatos::desconectar();
  header("Location: ver-tesis.php?f=6");
?>