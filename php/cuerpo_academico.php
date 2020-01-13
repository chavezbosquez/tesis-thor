<?php
/* Consulta de Cuerpos Académicos */
class CuerpoAcademico {
	public static $listaCuerposAcademicos = null;
	
	public function __construct() {
		exit('Función init no permitida');
	}
	
 	public static function getCuerposAcademicos() {
		if (null == self::$listaCuerposAcademicos) { 
			require_once 'bd.php';
			$pdo = BaseDeDatos::conectar();
			$sql = "SELECT clave,nombre FROM cuerpo_academico";
			$lista = array();
			foreach ($pdo->query($sql,PDO::FETCH_ASSOC) as $registro) {
      	array_push($lista, $registro);
			}
			self::$listaCuerposAcademicos = $lista;
			BaseDeDatos::desconectar();
		}
		return self::$listaCuerposAcademicos;
	}

	public static function getCuerpoAcademico($profesor) {
		require_once 'bd.php';
		$pdo = BaseDeDatos::conectar();
    $sql = "SELECT nombre FROM cuerpo_academico WHERE clave=(
							SELECT cuerpo_academico FROM profesor WHERE clave='{$profesor}' LIMIT 1)";
    $cons = $pdo->query($sql, PDO::FETCH_ASSOC);
		$nombreCA = $cons->fetchColumn();
		BaseDeDatos::desconectar();
    return($nombreCA);
	}
	
}
?>
