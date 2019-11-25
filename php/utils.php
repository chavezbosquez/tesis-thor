<?php
class Utils {
  /* Tipos de usuario */
  public static $SOLO_LECTURA = -1;
  public static $USUARIO_NORMAL = 0;
  public static $ADMIN = 1;
  /* Estatus de un usuario */
  public static $ACTIVO = 'Activo';
  public static $NO_ACTIVO = 'Inactivo';
  
	public function __construct() {
		exit('Función init no permitida');
  }

  /* Devuelve el nombre del usuario actual */
  public static function getUsuario() {
    return $_SESSION['login'];
  }

  /* Devuelve el tipo de usuario actual *
  public static function getAdmin() {
    return $_SESSION['admin'];
  }*/

  public static function isAdmin() {
    return $_SESSION['admin'] == $ADMIN;
  }

  public static function isSoloLectura() {
    return $_SESSION['admin'] == $SOLO_LECTURA;
  }

  /* Devuelve la fecha actual en el formato requerido por MySQL */
  public static function getHoy() {
    date_default_timezone_set("America/Mexico_City");
    $hoy = date("Y-m-d H:i:s");//date("y/m/d", time());
    return($hoy);
  }

  /* Elimina espacios en blanco, saltos de línea y tabuladores de las cajas de texto multilínea */
  public static function limpiarTexto($texto) {
    $buffer = str_replace(array("\r", "\n"), ' ', $texto);
    $buffer = trim($buffer);
    return($buffer);
  }

}
?>