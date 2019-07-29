<?php
  session_start();
  if ($_SESSION['login'] == '') {
    header("location: index.php");
  }
  if ( empty($_GET) ) {
    header("Location: ../inicio.php");
  }
  $matricula = $_GET['matricula'];
  require_once 'tesista.php';
  $tupla = Tesista::getFolioTesis($matricula);
  $folio   = $tupla['folio'];
  $nombre  = $tupla['nombre'];
  $estatus = $tupla['estatus'];
  if ( isset($folio) && !empty($folio) ) {
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
      case "FF": header("Location: ../inicio.php?error=2&tesis={$nombre}");//echo("final"); exit();
                exit();
    }
    header("Location: ../{$fSiguiente}.php?folio={$folio}");
  } else {
    header("Location: ../inicio.php?error=1&matricula={$matricula}");
  }
/*$listaTesista = Tesista::getTesista($matricula);

        if (!empty($listaTesista)) {
            
            foreach ($listaTesista as $tesista) {
                $pagina = '';
                extract($tesista);

                    if($ESTATUS == "F1"){
                        header('Location: ../f2.php?folio='.$FOLIO.'&sender=inicio&label=Inicio');
                    } else if ($ESTATUS == "F2"){
                        //ir a F3
                    } else if ($ESTATUS == "F3"){
                        //ir a F4
                    } else if ($ESTATUS == "F4"){
                        //ir a F5
                    } else if ($ESTATUS == "F5"){
                        //ir a F6
                    } else if ($ESTATUS == "F6"){
                        //ir a F7
                    } else if ($ESTATUS == "F7"){
                        //ir a F8
                    }
                
            
                break;
         }
            
            //ir al F que sigue
            //header('Location: ..//F-siguiente.php');
            //echo 'Si hay';
        }else {
            //regresar mensaje de error
            header('Location: ../inicio.php?error=1&matricula='.$matricula.'');
            //echo 'No hay';
        }*/
?>