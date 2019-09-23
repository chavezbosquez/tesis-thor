<?php
/* Consulta de profesores */
class Profesor {
	public static $listaProfesores = null;
	
	public function __construct() {
		exit('Función init no permitida');
	}
	
 	public static function getProfesores() {
		if (null == self::$listaProfesores) { 
			require_once 'bd.php';
			$pdo = BaseDeDatos::conectar();
			$sql = "SELECT clave,CONCAT(nombre, ' ', apellidos) AS nombreCompleto,cuerpo_academico AS cuerpoAcademico 
							FROM profesor ORDER BY nombre";
			$lista = array();
			foreach ($pdo->query($sql,PDO::FETCH_ASSOC) as $registro) {
      	array_push($lista, $registro);
			}
			self::$listaProfesores = $lista;
			BaseDeDatos::desconectar();
		}
		return self::$listaProfesores;
	}

	public static function getDatosProfesor($clave) {
		require_once 'bd.php';
		$pdo = BaseDeDatos::conectar();
    $sql = "SELECT CONCAT(profesor.nombre, ' ', apellidos) AS nombre, cuerpo_academico.nombre as cuerpoAcademico
                FROM profesor,cuerpo_academico
                WHERE profesor.clave LIKE '{$clave}'
                    AND profesor.cuerpo_academico=cuerpo_academico.clave
                    LIMIT 1";
    $cons = $pdo->query($sql, PDO::FETCH_ASSOC);
		$registro = $cons->fetch();
		BaseDeDatos::desconectar();
    return($registro);
	}
	
	public static function getTesisCompleta($folio) {
		require_once 'bd.php';
		$pdo = BaseDeDatos::conectar();
		$sql = "SELECT * FROM tesis WHERE folio={$folio} LIMIT 1";
		$lista = array();
		$registro = $pdo->query($sql,PDO::FETCH_ASSOC);
		extract($registro);

		array_push($lista, $fecha);
		array_push($lista, $folio);
		array_push($lista, $nombre);
		array_push($lista, $director);
		array_push($lista, $tesista1);
		array_push($lista, $tesista2);
		array_push($lista, $estatus);
		
		BaseDeDatos::desconectar();
		return $lista;
	}

}
?>