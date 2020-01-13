<?php
  /* Cerrar la sesión del usuario actual */
  session_start();
  if ($_SESSION['login']=='') {
      header("location: ../index.php");
  } else {
    unset($_SESSION["login"]);
    unset($_SESSION['admin']);
    header ('location: ../index.php');
  }
?>
