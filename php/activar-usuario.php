<?php
  /* Activar o desactivar un usuario */
  session_start();
  if ($_SESSION['login'] == '') {
    header("location: index.php");
  }
	if ( empty($_GET) ) {
    header("Location: inicio.php");
	}
	
	require_once 'usuario.php';
	$correo = $_GET['usuario'];
	$activar = $_GET['activar'];
	$resultado = Usuario::activarUsuario($correo,$activar);
	header("Location: ../admin.php");
?>