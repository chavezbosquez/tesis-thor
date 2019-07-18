<?php
  session_start();
  $clave = $_POST['clave'];
  $contra = $_POST['contra'];
  $ok = false;
  require 'bd.php';
  $pdo = BaseDeDatos::conectar();
  $cons = $pdo->query("SELECT contra,administrador FROM usuario WHERE correo='{$clave}' LIMIT 1",PDO::FETCH_ASSOC);
  $registro = $cons->fetch();
  if ($registro) {
    if ($registro['contra'] == $contra) {
      $ok = true;
      $_SESSION['login'] = $clave;
      $_SESSION['admin'] = $registro['administrador'];
    }
  }
  if ($ok) {
    echo "<form name='formulario' method='post' action='../inicio.php'>
          </form>";
  } else {
    echo "<form name='formulario' method='post' action='../index.php'>
			   <input type='hidden' name='error' value='1'>
		 	   <input type='hidden' name='clave' value='{$clave}'/>
		 	   <input type='hidden' name='contra' value='{$contra}'>
		     </form>";
  }
  BaseDeDatos::desconectar();
?>
<script> 
  //Redireccionar con el formulario creado
  document.formulario.submit();
</script>
