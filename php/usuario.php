<?php
class Usuario {
	public static $listaUsuarios = null;
	
	public function __construct() {
		exit('Función init no permitida');
	}
	
 	public static function getUsuarios() {
		if (null == self::$listaProfesores) { 
			require_once 'bd.php';
			$pdo = BaseDeDatos::conectar();
			$sql = "SELECT correo,contra,CONCAT(nombre, ' ', apellidos) AS nombreCompleto,fecha,estatus,administrador 
							FROM usuario ORDER BY fecha";
			$lista = array();
			foreach ($pdo->query($sql,PDO::FETCH_ASSOC) as $registro) {
      	array_push($lista, $registro);
			}
			self::$listaProfesores = $lista;
			BaseDeDatos::desconectar();
		}
		return self::$listaProfesores;
	}

}
?>