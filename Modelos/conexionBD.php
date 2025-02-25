<?php  // Modelos/conexcionBD.php
class ConexionBD {
    // Configuración de la base de datos
    private static $host = 'localhost';
    private static $usuario = 'root';
    private static $password = '';
    private static $db = 'crud';

    static public function cBD($tipo = 'mysqli') {
        if ($tipo === 'mysqli') {
            // Conexión con MySQLi
            $cbd = new mysqli(self::$host, self::$usuario, self::$password, self::$db);
            if ($cbd->connect_error) {
                die('Error de conexión: ' . $cbd->connect_error);
            }
            return $cbd;
        } elseif ($tipo === 'pdo') {
            // Conexión con PDO
            try {
                $cbd = new PDO('mysql:host=' . self::$host . ';dbname=' . self::$db, self::$usuario, self::$password);
                $cbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $cbd;
            } catch (PDOException $e) {
                die('Error de conexión: ' . $e->getMessage());
            }
        } else {
            throw new Exception('Tipo de conexión no soportado');
        }
    }
}

?>