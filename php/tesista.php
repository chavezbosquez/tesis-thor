<?php
/* Consulta de tesistas */
class Tesista {

	public function __construct() {
		exit('Función init no permitida');
	}
	
	public static function getNombre($matricula) {
		require_once 'bd.php';
		$pdo = BaseDeDatos::conectar();
    $sql = "SELECT CONCAT(nombre, ' ', apellidos) AS nombre, carrera
                FROM tesista WHERE matricula LIKE '{$matricula}' LIMIT 1";
    $cons = $pdo->query($sql, PDO::FETCH_ASSOC);
		$registro = $cons->fetch();
		BaseDeDatos::desconectar();
    return($registro);
	}

	public static function getDatos($matricula) {
		require_once 'bd.php';
		$pdo = BaseDeDatos::conectar();
    $sql = "SELECT CONCAT(nombre, ' ', apellidos) AS nombre, carrera, correo, telefono, movil, domicilio, localidad
                FROM tesista WHERE matricula LIKE '{$matricula}' LIMIT 1";
    $cons = $pdo->query($sql, PDO::FETCH_ASSOC);
		$registro = $cons->fetch();
		BaseDeDatos::desconectar();
    return($registro);
	}

	public static function getFolioTesis($matricula) {
		require_once 'bd.php';
		$pdo = BaseDeDatos::conectar();
    $sql = "SELECT folio,nombre,estatus FROM tesis WHERE tesista1 LIKE '{$matricula}' OR tesista2 LIKE '{$matricula}' LIMIT 1";
		$cons = $pdo->query($sql, PDO::FETCH_ASSOC);
		$registro = $cons->fetch();
		BaseDeDatos::desconectar();
    return($registro);
	}

}
?>