<?php
class Archivo {

	public function __construct() {
		exit('Función init no permitida');
	}
	
 	public static function errorArchivo($archivo) {
		if ($_FILES[$archivo]["error"] > 0) {
      die ("Error al cargar el archivo 1. ¿Archivo demasiado grande? Código: " . $_FILES[$archivo]["error"] . "<br>");
    }
	}

	public static function cargarArchivo($archivo, $directorio) {
		if ( !move_uploaded_file($_FILES[$archivo]["tmp_name"], $directorio . $_FILES[$archivo]["name"]) ) {
			die ("Error al copiar el archivo. Código: " . $_FILES[$archivo]["error"]);
		}
	}

}
?>