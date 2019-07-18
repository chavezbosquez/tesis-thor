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
  
  $hoy = date("y/m/d", time());
  $pdo = BaseDeDatos::conectar();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  /* Guardar el oficio */
  Archivo::errorArchivo("archivo");
  
  $directorio = "docs/";// . $folio;
  $nombreArchivo = $folio . "-F5.pdf";
  $_FILES["archivo"]["name"] = $nombreArchivo;
  Archivo::cargarArchivo("archivo",$directorio);

  /****************************** INSERTAR DATOS *****************************/
    
  /* Guardar datos del F5 */
  $sql = "UPDATE tesis SET estatus='F5' WHERE folio='{$folio}'";
  $cons = $pdo->prepare($sql);
  $cons->execute();

  /* Guardar el documento */
  $sql = "INSERT INTO documento(tipo_documento,nombre_archivo,tesis,fecha) VALUES(?,?,?,?)";
  $cons = $pdo->prepare($sql);
  $cons->execute( array("F5",$nombreArchivo,$folio,$fecha) );

  /* Bitácora del Sistema */
  $sql = "INSERT INTO bitacora(tesis,operacion,fecha,usuario) VALUES(?,?,?,?)";
  $cons = $pdo->prepare($sql);
  $cons->execute( array($folio,"Registro del F5",$hoy,$usuario) );

  BaseDeDatos::desconectar();
  header("Location: ver-tesis.php?f=5");
?>