<?php
  /* Gestiona el acceso a THOR. Dos tipos de usuario: 
    0 - Auxiliar
    1 - Administador
    2 - ¿Solo lectura? */
  session_start();
  $clave = $_POST['clave'];
  $contra = $_POST['contra'];
  $ok = false;
  require 'bd.php';
  require 'utils.php';
  $pdo = BaseDeDatos::conectar();
  $cons = $pdo->query("SELECT contra,administrador,estatus FROM usuario WHERE correo='{$clave}' LIMIT 1",PDO::FETCH_ASSOC);
  $registro = $cons->fetch();
  if ($registro) {
    if ($registro['contra'] == $contra && $registro['estatus'] == Utils::$ACTIVO) {
      $ok = true;
      /* Datos del usuario actual */
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
  //Redireccionar a la página correspondiente usando el formulario creado
  document.formulario.submit();
</script>
