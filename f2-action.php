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
  
  /* Datos generales */
	$folio = $_POST['folio'];
  $fecha = $_POST['fecha'];

  /* Datos de los revisores */
  $revisor1 = $_POST['revisor1'];
  $revisor2 = $_POST['revisor2'];
  $revisor3 = $_POST['revisor3'];
  
  /* Datos del primer tesista*/
  $numTesistas = 1;
  $matriculaTesista1 = $_POST['tesista1'];
  $correo1    = $_POST['correo1'];
  $telefono1a = $_POST['telefono1a'];
  $telefono1b = $_POST['telefono1b'];
  $domicilio1 = $_POST['domicilio1'];
  $localidad1 = $_POST['localidad1'];
  /* Hay segundo tesista */
  $matriculaTesista2 = null;
  $correo2    = null;
  $telefono2a = null;
  $telefono2b = null;
  $domicilio2 = null;
  $localidad2 = null;
  if ( isset($_POST['hayTesista2']) ) {
    $numTesistas = 2;
    $matriculaTesista2 = $_POST['tesista2'];
    $correo2    = $_POST['correo2'];
    $telefono2a = $_POST['telefono2a'];
    $telefono2b = $_POST['telefono2b'];
    $domicilio2 = $_POST['domicilio2'];
    $localidad2 = $_POST['localidad2'];
  }
  
  /* Gestión del archivo: 
    1- Verificar error en la carga
    2- Crear la carpeta con el folio
    3- Construir el nombre del archivo a partir del folio + "-F1" */
  if ($_FILES["archivo"]["error"] > 0) {
    die ("Error al cargar el archivo. ¿Archivo demasiado grande? Código: " . $_FILES["archivo"]["error"] . "<br>");
  }

  $directorio = "docs/";// . $folio;
  
  $nombreArchivo = $folio . "-F2.pdf";
  $_FILES["archivo"]["name"] = $nombreArchivo;
  if ( !move_uploaded_file($_FILES["archivo"]["tmp_name"], $directorio . $_FILES["archivo"]["name"]) ) {
    die ("Error al copiar el archivo. Código: " . $_FILES["archivo"]["error"]);
  }

  /***************************************************************************/
  /****************************** INSERTAR DATOS *****************************/
  /***************************************************************************/
  $hoy = date("y/m/d", time());
  $pdo = BaseDeDatos::conectar();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  /* Guardar primero los datos de tesistas */
  /*$sql = "UPDATE tesista SET
            correo='{$correo1}',
            telefono='{$telefono1a}',
            movil='{$telefono1b}',
            domicilio='{$domicilio1}',
            localidad='{$localidad1}'
          WHERE matricula='{$matriculaTesista1}'";
  $cons = $pdo->prepare($sql);
  $cons->execute();*/
  $sql = "UPDATE tesista SET
            correo=?,
            telefono=?,
            movil=?,
            domicilio=?,
            localidad=?
          WHERE matricula=?";
  $cons = $pdo->prepare($sql);
  $cons->execute( array($correo1,$telefono1a,$telefono1b,$domicilio1,$localidad1,$matriculaTesista1) );

  if ($numTesistas == 2) {
    /*$sql = "UPDATE tesista SET
            correo=?,
            telefono=?,
            movil=?,
            domicilio=?,
            localidad=?
          WHERE matricula=?";
    $cons = $pdo->prepare($sql);*/
    $cons->execute( array($correo2,$telefono2a,$telefono2b,$domicilio2,$localidad2,$matriculaTesista2) );
  }

  /* Guardar datos del F2 */
  $sql = "UPDATE tesis SET 
            estatus='F2',
            revisor1='{$revisor1}',
            revisor2='{$revisor2}',
            revisor3='{$revisor3}'
          WHERE folio='{$folio}'";
  $cons = $pdo->prepare($sql);
  $cons->execute();

  /* Guardar el documento */
  $sql = "INSERT INTO documento(tipo_documento,nombre_archivo,tesis,fecha) VALUES(?,?,?,?)";
  $cons = $pdo->prepare($sql);
  $cons->execute( array("F2",$nombreArchivo,$folio,$fecha) );

  /* Bitácora del Sistema */
  $sql = "INSERT INTO bitacora(tesis,operacion,fecha,usuario) VALUES(?,?,?,?)";
  $cons = $pdo->prepare($sql);
  $cons->execute( array($folio,"Registro del F2",$hoy,$usuario) );

  BaseDeDatos::desconectar();
  header("Location: ver-anteproyecto.php?f=2");
?>