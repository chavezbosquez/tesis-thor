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
  $fecha   = $_POST['fecha'];
  
  /* Datos del jurado */
  $jurado1 = $_POST['jurado1'];
  $jurado2 = $_POST['jurado2'];
  $jurado3 = $_POST['jurado3'];
  $jurado4 = $_POST['jurado4'];
  $jurado5 = $_POST['jurado5'];
  
  $hoy = date("y/m/d", time());
  $pdo = BaseDeDatos::conectar();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  Archivo::errorArchivo("archivo");

  $directorio = "docs/" . $folio . "/";

  $nombreArchivo = $folio . "-F7.pdf";
  $_FILES["archivo"]["name"] = $nombreArchivo;
  Archivo::cargarArchivo("archivo",$directorio);
    
    /****************************** INSERTAR DATOS *****************************/
    
    /* Guardar datos del F7 */
    //$sql = "UPDATE tesis SET estatus='F7' WHERE folio='{$folio}'";
    $sql = "UPDATE tesis SET 
            estatus='F7',
            jurado1='{$jurado1}',
            jurado2='{$jurado2}',
            jurado3='{$jurado3}',
            jurado4='{$jurado4}',
            jurado5='{$jurado5}'
          WHERE folio='{$folio}'";
    $cons = $pdo->prepare($sql);
    $cons->execute();

    /* Guardar el documento */
    $sql = "INSERT INTO documento(tipo_documento,nombre_archivo,tesis,fecha) VALUES(?,?,?,?)";
    $cons = $pdo->prepare($sql);
    $cons->execute( array("F7",$nombreArchivo,$folio,$fecha) );
    
    /* Bitácora del Sistema */
    $sql = "INSERT INTO bitacora(tesis,operacion,fecha,usuario) VALUES(?,?,?,?)";
    $cons = $pdo->prepare($sql);
    $cons->execute( array($folio,"Registro del F7",$hoy,$usuario) );

  BaseDeDatos::desconectar();
  header("Location: ver-tesis.php?f=7");
?>