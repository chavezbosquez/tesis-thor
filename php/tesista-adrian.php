<?php
class Tesista {   
    public static $listaTesista = null;
    	
	public function __construct() {
		exit('Función init no permitida');
	}
	
 	public static function getTesista($matricula) {
		if (null == self::$listaTesista) { 
			require_once 'bd.php'; //incluye la conexion de la base de datos
			$pdo = BaseDeDatos::conectar();
			$sql = "SELECT t.folio AS FOLIO, 
                           t.nombre AS NOMBRE_TESIS, 
                           t.tesista1 AS TESISTA_1, 
                           t.tesista2 AS TESISTA_2, 
                           t.estatus AS ESTATUS 
                           FROM tesis t 
                           INNER JOIN tesista a ON t.tesista1 = a.matricula 
                           WHERE t.tesista1 = '".$matricula."' OR t.tesista2 = '".$matricula."'";
			$lista = array();
			foreach ($pdo->query($sql) as $registro) {
      	        array_push($lista, $registro);
			}
			self::$listaTesista = $lista;
			BaseDeDatos::desconectar();
		}
		return self::$listaTesista;
	}
	
}

$matricula = $_GET['matricula'];
$listaTesista = Tesista::getTesista($matricula);

        if (!empty($listaTesista)) {
            
            foreach ($listaTesista as $tesista) {
                $pagina = '';
                extract($tesista);

                    if($ESTATUS == "F1")
                        $pagina = 'f2.php';
                    else if ($ESTATUS == "F2")
                        $pagina = 'f3.php';
                    else if ($ESTATUS == "F3")
                        $pagina = 'f4.php';
                    else if ($ESTATUS == "F4")
                        $pagina = 'f5.php';
                    else if ($ESTATUS == "F5")
                        $pagina = 'f6.php';
                    else if ($ESTATUS == "F6")
                        $pagina = 'f7.php';
                    else if ($ESTATUS == "F7")
                        $pagina = 'f8.php';
                
            header('Location: ../'.$pagina.'');
                break;
         }
            
            //ir al F que sigue
            //header('Location: ..//F-siguiente.php');
            //echo 'Si hay';
        }else {
            //regresar mensaje de error
            header('Location: ../inicio.php?error=1&matricula='.$matricula.'');
            //echo 'No hay';
        }

?>