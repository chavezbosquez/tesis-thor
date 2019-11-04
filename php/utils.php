<?php
class Utils {
  /* Constantes globales del sistema */
  public static $ACTIVO = 'Activo';
  public static $NO_ACTIVO = 'Inactivo';

	public function __construct() {
		exit('Función init no permitida');
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