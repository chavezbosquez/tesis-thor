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

  /* Guardar los oficios */
  Archivo::errorArchivo("archivo1");
  Archivo::errorArchivo("archivo2");

  $directorio = "docs/" . $folio . "/";
  
  $nombreArchivo1 = $folio . "-FF.pdf";
  $_FILES["archivo1"]["name"] = $nombreArchivo1;
  $nombreArchivo2 = $folio . "-IMPRESION.pdf";
  $_FILES["archivo2"]["name"] = $nombreArchivo2;
  Archivo::cargarArchivo("archivo1",$directorio);
  Archivo::cargarArchivo("archivo2",$directorio);

  /****************************** INSERTAR DATOS *****************************/
    
  /* Guardar datos finales */
  $sql = "UPDATE tesis SET estatus='FF' WHERE folio='{$folio}'";
  $cons = $pdo->prepare($sql);
  $cons->execute();

  /* Guardar los documentos */
  $sql = "INSERT INTO documento(tipo_documento,nombre_archivo,tesis,fecha) VALUES(?,?,?,?)";
  $cons = $pdo->prepare($sql);
  $cons->execute( array("FF",$nombreArchivo1,$folio,$fecha) );
  $cons->execute( array("IMPRESION",$nombreArchivo2,$folio,$fecha) );

  /* Bitácora del Sistema */
  $sql = "INSERT INTO bitacora(tesis,operacion,fecha,usuario) VALUES(?,?,?,?)";
  $cons = $pdo->prepare($sql);
  $cons->execute( array($folio,"Formatos Finales",$hoy,$usuario) );

  BaseDeDatos::desconectar();
  header("Location: inicio.php");
?>