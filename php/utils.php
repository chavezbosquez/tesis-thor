<?php
class Utils {

	public function __construct() {
		exit('Función init no permitida');
  }

  public static function getHoy() {
    date_default_timezone_set("America/Mexico_City");
    $hoy = date("Y-m-d H:i:s");//date("y/m/d", time());
    return($hoy);
  }

}
?>