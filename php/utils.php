<?php
class Utils {
  /* Constantes globales del sistema */
  public const ACTIVO = 'Activo';
  public const NO_ACTIVO = 'Inactivo';

	public function __construct() {
		exit('Función init no permitida');
  }

  public static function getHoy() {
    date_default_timezone_set("America/Mexico_City");
    $hoy = date("Y-m-d H:i:s");//date("y/m/d", time());
    return($hoy);
  }

  public static function limpiarTexto($texto) {
    $buffer = str_replace(array("\r", "\n"), ' ', $texto);
    $buffer = trim($buffer);
    return($buffer);
  }

}
?>