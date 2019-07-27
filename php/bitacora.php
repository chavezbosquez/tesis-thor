<?php
class Bitacora {

	public function __construct() {
		exit('Función init no permitida');
	}
	
 	public static function getLog($folio) {
		require_once 'bd.php';
		$pdo = BaseDeDatos::conectar();
    $sql = "SELECT operacion,fecha,usuario FROM bitacora WHERE tesis LIKE '{$folio}'";
    $registro = $pdo->query($sql, PDO::FETCH_ASSOC);
		BaseDeDatos::desconectar();
    return($registro);
	}

}
?>