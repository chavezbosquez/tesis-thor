<?php
/* Gestión de usuarios */
class Usuario {
	public static $listaUsuarios = null;
	
	public function __construct() {
		exit('Función init no permitida');
	}
	
	/*Listado de usuarios no-administradores */
 	public static function getUsuarios() {
		if (null == self::$listaUsuarios) {
			require_once 'bd.php';
			$pdo = BaseDeDatos::conectar();
			$sql = "SELECT correo,contra,CONCAT(nombre, ' ', apellidos) AS nombreCompleto,fecha,estatus
							FROM usuario WHERE administrador = 0 ORDER BY fecha";
			$lista = array();
			foreach ($pdo->query($sql,PDO::FETCH_ASSOC) as $registro) {
      	array_push($lista, $registro);
			}
			self::$listaUsuarios = $lista;
			BaseDeDatos::desconectar();
		}
		return self::$listaUsuarios;
	}

	/* Habilita/deshabilita el acceso del usuario al Sistema */
	public static function activarUsuario($correo,$activar) {
		require_once 'bd.php';
		require_once 'utils.php';

		$pdo = BaseDeDatos::conectar();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if ( $activar ) {
			$sql = "UPDATE usuario SET estatus='" . Utils::$ACTIVO    ."' WHERE correo='$correo'";
		} else {
			$sql = "UPDATE usuario SET estatus='" . INACTIVO . "' WHERE correo='$correo'";
		}
		$cons = $pdo->prepare($sql);
		$cons->execute();
		BaseDeDatos::desconectar();
		return "OK";
	}

}
?>