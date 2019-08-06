<?php
class Tesis {

	public function __construct() {
		exit('Función init no permitida');
	}
  
  private static function getData($sql) {
    require_once 'bd.php';
    $pdo = BaseDeDatos::conectar();
    $cons = $pdo->query($sql, PDO::FETCH_ASSOC);
    $registro = $cons->fetch();
		BaseDeDatos::desconectar();
    return($registro);
  }

	public static function getTodosLosDatos($folio) {
		require_once 'bd.php';
		$pdo = BaseDeDatos::conectar();
    $sql = "SELECT folio,fecha,tesis.nombre,tesista1,tesista2,director,codirector,codirector_externo,institucion_externa,tesis.estatus,
            cuerpo_academico.nombre as nombreCA,
            CONCAT(profesor.nombre, ' ', profesor.apellidos) AS nombreDirector,
            CONCAT(tesista.nombre, ' ', tesista.apellidos) AS nombreTesista,tesista.carrera,
              tesista.correo,tesista.telefono,tesista.movil,tesista.domicilio,tesista.localidad
                FROM tesis,cuerpo_academico,profesor,tesista
                WHERE folio='{$folio}'
                    AND director=profesor.clave
                    AND tesista1=tesista.matricula
                    AND profesor.cuerpo_academico=cuerpo_academico.clave
                    LIMIT 1";
                    //AND (tesis.estatus LIKE 'F1%' OR tesis.estatus LIKE 'F2%' OR tesis.estatus LIKE 'F3%')
    $cons = $pdo->query($sql, PDO::FETCH_ASSOC);
    $registro = $cons->fetch();
		BaseDeDatos::desconectar();
    return($registro);
	}

  /* Útil para el F2 */
	public static function getDatos($folio) {
		require_once 'bd.php';
		$pdo = BaseDeDatos::conectar();
    //$sql = "SELECT nombre FROM tesis WHERE folio LIKE '{$folio}' LIMIT 1";
    $sql = "SELECT tesis.nombre,tesista1,tesista2,
            CONCAT(tesista.nombre, ' ', tesista.apellidos) AS nombreTesista
              FROM tesis,tesista
                WHERE folio='{$folio}' AND tesista1=tesista.matricula LIMIT 1";
    $cons = $pdo->query($sql, PDO::FETCH_ASSOC);
		$registro = $cons->fetch();
		BaseDeDatos::desconectar();
    return($registro);
  }
  
  /* Útil para el F3 */
  public static function getDatosF3($folio) {
		require_once 'bd.php';
		$pdo = BaseDeDatos::conectar();
    $sql = "SELECT nombre,revisor1,revisor2,revisor3,estatus FROM tesis WHERE folio='{$folio}' LIMIT 1";
    $cons = $pdo->query($sql, PDO::FETCH_ASSOC);
		$registro = $cons->fetch();
		BaseDeDatos::desconectar();
    return($registro);
  }

  /* Útil para el F4 */
  public static function getDatosF4($folio) {
		require_once 'bd.php';
		$pdo = BaseDeDatos::conectar();
    $sql = "SELECT nombre,director,codirector FROM tesis WHERE folio='{$folio}' LIMIT 1";
    $cons = $pdo->query($sql, PDO::FETCH_ASSOC);
		$registro = $cons->fetch();
		BaseDeDatos::desconectar();
    return($registro);
  }

  /* Útil para el F8 */
  public static function getDatosF8($folio) {
		require_once 'bd.php';
		$pdo = BaseDeDatos::conectar();
    $sql = "SELECT nombre,jurado1,jurado2,jurado3,jurado4,jurado5,estatus FROM tesis WHERE folio='{$folio}' LIMIT 1";
    $cons = $pdo->query($sql, PDO::FETCH_ASSOC);
		$registro = $cons->fetch();
		BaseDeDatos::desconectar();
    return($registro);
  }

  /* Obtener la fecha límite para titularse */
  public static function getFechaFatal($folio) {
		require_once 'bd.php';
		$pdo = BaseDeDatos::conectar();
    //$sql = "SELECT fecha FROM documento WHERE tesis='{$folio}' AND tipo_documento='F4' LIMIT 1";
    $sql = "SELECT fecha_fatal FROM tesis WHERE folio='{$folio}' LIMIT 1";
    $cons = $pdo->query($sql, PDO::FETCH_ASSOC);
    $f = $cons->fetchColumn();
    if ( !isset($f) ) {
      return(null);
    }
    $f = strtotime($f);
    $n = strtotime('+ 1 year', $f);
    $fecha = date('d/m/Y', $n);

		BaseDeDatos::desconectar();
    return($fecha);
  }

  public static function getTablaAnteproyectos() {
    require_once 'php/bd.php';
    $pdo = BaseDeDatos::conectar();
    $sql = "SELECT folio,nombre,tesista1,tesista2,director,estatus 
            FROM tesis 
            WHERE estatus LIKE 'F1%' OR estatus LIKE 'F2%' OR estatus LIKE 'F3%'";
    $cons = $pdo->query($sql, PDO::FETCH_ASSOC);
    $registro = $cons->fetchAll();
		BaseDeDatos::desconectar();
    return($registro);
  }

}
?>