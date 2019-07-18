<?php
  session_start();
  if($_SESSION['login']==''){
      header("location: ../index.php");
  } else {
    unset($_SESSION["login"]);
    /*unset($_SESSION["ures"]);
    unset($_SESSION["nombre"]);
    unset($_SESSION["adm"]);*/
    header ('location: ../index.php');
  }
?>
