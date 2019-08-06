<?php
  session_start();
  if ($_SESSION['login'] == '') {
    header("location: index.php");
  }
  /* Si no hay formulario entonces dirigir a la página inicial */
  if ( empty($_POST) ) {
    header("Location: inicio.php");
  }
  /* Requerimos el usario actual para guardar la operación en la bitácora */
  $usuario = $_SESSION['login'];
  /* Clase que contiene la conexión a la base de datos */
  require_once 'php/bd.php';
  
  /* Datos generales */
  $folio = $_POST['folio'];
  $nombre = $_POST['nombre'];
  $fecha = $_POST['fecha'];
  
  /* Director de tesis */
  $director = $_POST['director'];

  /* ¿Hay codirector de tesis? */
  $hayCodirector = isset($_POST['hayCodirector']);
  $codirector    = null;
  if ($hayCodirector) {
    $codirector = $_POST['codirector'];
  }

  /* ¿Hay codirector externo? */
  $hayExterno  = isset($_POST['hayExterno']);
  $externo     = null;
  $institucion = null;
  if ($hayExterno) {
    $externo     = $_POST['externo'];
    $institucion = $_POST['institucion'];
  }

  /* Datos del primer tesista*/
  $matriculaTesista1 = $_POST['matricula1'];
  $nombreTesista1    = $_POST['nombre1'];
  $apellidosTesista1 = $_POST['apellidos1'];
  $carreraTesista1   = $_POST['carrera1'];
  /* ¿Hay segundo tesista? */
  $hayTesista2 = isset($_POST['hayTesista2']);
  $matriculaTesista2 = null;
  $nombreTesista2    = null;
  $apellidosTesista2 = null;
  $carreraTesista2   = null;
  if ($hayTesista2) {
    $matriculaTesista2 = $_POST['matricula2'];
    $nombreTesista2    = $_POST['nombre2'];
    $apellidosTesista2 = $_POST['apellidos2'];
    $carreraTesista2   = $_POST['carrera2'];
  }

  /* Gestión del archivo: 
    1- Verificar error en el archivo
    2- Crear la carpeta con el folio
    3- Construir el nombre del archivo a partir del folio + "-F1" */
  /* 1- Error de archivo */
  if ($_FILES["archivo"]["error"] > 0) {
    die ("Error al cargar el archivo. ¿Archivo demasiado grande? Código: " . $_FILES["archivo"]["error"] . "<br>");
  }

  /* 2- Crear la carpeta con el folio */
  $oldmask = umask(0);
  $directorio = "docs/" . $folio . "/";
  if ( !file_exists($directorio) ) {
    mkdir($directorio, 0777, true);
  } else {
    die("No es posible crear el directorio. Contacte al Administrador del Sistema.");
  }
  umask($oldmask);

  /* Nombrar archivo y enviarlo al servidor */
  $nombreArchivo = $folio . "-F1.pdf";
  $_FILES["archivo"]["name"] = $nombreArchivo;
  if ( !move_uploaded_file($_FILES["archivo"]["tmp_name"], $directorio . $_FILES["archivo"]["name"]) ) {
    die ("Error al copiar el archivo. Código: " . $_FILES["archivo"]["error"]);
  }

  /****************************** INSERTAR DATOS *****************************/

  /* INTEGRIDAD REFERENCIAL: Guardar primero los datos de tesistas */
  $pdo = BaseDeDatos::conectar();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "INSERT INTO tesista(matricula,nombre,apellidos,carrera) VALUES(?,?,?,?)";
  $cons = $pdo->prepare($sql);
  $cons->execute( array($matriculaTesista1,$nombreTesista1,$apellidosTesista1,$carreraTesista1) );

  /* Guardar los datos del segundo tesita (si lo hay) */
  if ($hayTesista2) {
    $cons = $pdo->prepare($sql);
    $cons->execute( array($matriculaTesista2,$nombreTesista2,$apellidosTesista2,$carreraTesista2) );
  }

  /* INTEGRIDAD REFERENCIAL: Guardar datos del F1 */
  $sql = "INSERT INTO tesis(folio,nombre,director,codirector,codirector_externo,institucion_externa,tesista1,tesista2,fecha,estatus) 
        VALUES(?,?,?,?,?,?,?,?,?,?)";
  $cons = $pdo->prepare($sql);
  $cons->execute( array($folio,$nombre,$director,$codirector,$externo,$institucion,$matriculaTesista1,$matriculaTesista2,$fecha,"F1") );

  /* Guardar datos del documento */
  $sql = "INSERT INTO documento(tipo_documento,nombre_archivo,tesis,fecha) VALUES(?,?,?,?)";
  $cons = $pdo->prepare($sql);
  $cons->execute( array("F1",$nombreArchivo,$folio,$fecha) );

  /* Bitácora del Sistema */
  date_default_timezone_set("America/Mexico_City");
  $hoy = date("Y-m-d H:i:s");//date("y/m/d", time());
  $sql = "INSERT INTO bitacora(tesis,operacion,fecha,usuario) VALUES(?,?,?,?)";
  $cons = $pdo->prepare($sql);
  $cons->execute( array($folio,"Registro del F1",$hoy,$usuario) );

  BaseDeDatos::desconectar();
  header("Location: ver-anteproyecto.php?f=1");
?>