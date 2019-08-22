<?php
/* Conexión global a la base de datos */
class BaseDeDatos {
	private static $bd       = 'tesis_thor';
	private static $host     = 'localhost';
	private static $usuario  = 'root';
	private static $password = '';
	
	private static $cont     = null;
	
	public function __construct() {
		exit('Función init no permitida');
	}
	
	public static function conectar() {
	   // Una conexión para toda la aplicación
       if (null == self::$cont) {
        try {
          self::$cont =  new PDO("mysql:host=" . self::$host . ";" . "dbname=" . self::$bd . ";". "charset=utf8", 
                                 self::$usuario,
                                 self::$password,
                                 array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        }
        catch(PDOException $e) {
          die($e->getMessage());  
        }
       }
       return self::$cont;
	}
	
	public static function desconectar() {
		self::$cont = null;
	}
}
?>
