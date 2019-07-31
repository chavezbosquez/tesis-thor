<?php
  session_start();
  if ($_SESSION['login'] == '') {
    header("location: index.php");
  }
  if ( empty($_GET) ) {
    header("Location: ../inicio.php");
  }
  /* ¿Búsqueda por matrícula o por tesis? */
  $tupla = null;
  $folio = null;
  if ( isset($_GET['matricula']) ) {
    require_once 'tesista.php';
    $matricula = $_GET['matricula'];
    $tupla = Tesista::getFolioTesis($matricula);
    $folio   = $tupla['folio'];
  } else if ( isset($_GET['folio']) ) {
    require_once 'tesis.php';
    $folio = $_GET['folio'];
    $tupla = Tesis::getDatosF3($folio);
  }
  $nombre  = $tupla['nombre'];
  $estatus = $tupla['estatus'];
  if ( isset($estatus) && !empty($estatus) ) {
    //header("Location: ../ver-detalle-tesis.php?folio={$folio}");
    switch ($estatus) {
      case "F1": $fSiguiente = "f2";
                break;
      case "F2": $fSiguiente = "f3";
                break;
      case "F3-A": $fSiguiente = "f3";
                break;
      case "F3": $fSiguiente = "f4";
                break;
      case "F4": $fSiguiente = "f5";
                break;
      case "F5": $fSiguiente = "f6";
                break;
      case "F6": $fSiguiente = "f7";
                break;
      case "F7": $fSiguiente = "f8";
                break;
      case "F8-A": $fSiguiente = "f8";
                break;
      case "F8": $fSiguiente = "ff";
                break;
      case "FF": header("Location: ../inicio.php?error=2&tesis={$nombre}");
                exit();
    }
    header("Location: ../{$fSiguiente}.php?folio={$folio}");
  } else {
    if ( isset($matricula) ) {
      header("Location: ../inicio.php?error=1&matricula={$matricula}");
    } else {
      header("Location: ../inicio.php?error=3&folio={$folio}");
    }
  }
?>