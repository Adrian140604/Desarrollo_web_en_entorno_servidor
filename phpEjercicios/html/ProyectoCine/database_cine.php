<?php
class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $host = 'phpejercicios-db-1'; // Nombre del contenedor de BD
        $dbname = 'cine'; // Nombre de la base de datos
        $username = 'cine'; // Usuario que se va a conectar
        $password = 'cine'; // Password del usuario
        
        try {
            $this->connection = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Cambiar el manejo de errores para no mostrar salida
            // Puedes registrar el error en un archivo o en el log del servidor
            error_log("Error de conexión: " . $e->getMessage());
            // No usar die(), sino una excepción si es necesario
            throw new Exception("No se pudo conectar a la base de datos.");
        }
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}


