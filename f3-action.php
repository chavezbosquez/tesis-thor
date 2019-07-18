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

  /* Dependiendo del estatus se guardarán diferentes archivos */
  if ($estatus == "F2") {
    /* Guardar los oficios de la Comisión revisora */
    Archivo::errorArchivo("archivo1");
    Archivo::errorArchivo("archivo2");
    Archivo::errorArchivo("archivo3");

    $directorio = "docs/";// . $folio;
    $nombreArchivo1 = $folio . "-REVISOR1.pdf";
    $_FILES["archivo1"]["name"] = $nombreArchivo1;
    $nombreArchivo2 = $folio . "-REVISOR2.pdf";
    $_FILES["archivo2"]["name"] = $nombreArchivo2;
    $nombreArchivo3 = $folio . "-REVISOR3.pdf";
    $_FILES["archivo3"]["name"] = $nombreArchivo3;
    Archivo::cargarArchivo("archivo1",$directorio);
    Archivo::cargarArchivo("archivo2",$directorio);
    Archivo::cargarArchivo("archivo3",$directorio);
    
    /****************************** INSERTAR DATOS *****************************/
    
    /* Guardar datos del F3 */
    $sql = "UPDATE tesis SET estatus='F3-A' WHERE folio='{$folio}'";
    $cons = $pdo->prepare($sql);
    $cons->execute();

    /* Guardar los documentos */
    $sql = "INSERT INTO documento(tipo_documento,nombre_archivo,tesis,fecha) VALUES(?,?,?,?)";
    $cons = $pdo->prepare($sql);
    $cons->execute( array("REVISOR1",$nombreArchivo1,$folio,$hoy) );
    $cons->execute( array("REVISOR2",$nombreArchivo2,$folio,$hoy) );
    $cons->execute( array("REVISOR3",$nombreArchivo3,$folio,$hoy) );
  
    /* Bitácora del Sistema */
    $sql = "INSERT INTO bitacora(tesis,operacion,fecha,usuario) VALUES(?,?,?,?)";
    $cons = $pdo->prepare($sql);
    $cons->execute( array($folio,"Registro del Comité Revisor",$hoy,$usuario) );

  } else if ($estatus == "F3-A") {
    /* Guardar el F3 */
    $fecha = $_POST['fecha'];

    Archivo::errorArchivo("archivo4");
    $directorio = "docs/";// . $folio;
    $nombreArchivo4 = $folio . "-F3.pdf";
    $_FILES["archivo4"]["name"] = $nombreArchivo4;
    Archivo::cargarArchivo("archivo4",$directorio);
    
    /****************************** INSERTAR DATOS *****************************/
    /* Guardar datos del F3 */
    $sql = "UPDATE tesis SET estatus='F3' WHERE folio='{$folio}'";
    $cons = $pdo->prepare($sql);
    $cons->execute();

    /* Guardar el documento */
    $sql = "INSERT INTO documento(tipo_documento,nombre_archivo,tesis,fecha) VALUES(?,?,?,?)";
    $cons = $pdo->prepare($sql);
    $cons->execute( array("F3",$nombreArchivo4,$folio,$hoy) );
    
    /* Bitácora del Sistema */
    $sql = "INSERT INTO bitacora(tesis,operacion,fecha,usuario) VALUES(?,?,?,?)";
    $cons = $pdo->prepare($sql);
    $cons->execute( array($folio,"Registro del F3",$hoy,$usuario) );

  } else {
    die("Error de estatus.");
  }

  BaseDeDatos::desconectar();
  header("Location: ver-anteproyecto.php?f=3");
?>