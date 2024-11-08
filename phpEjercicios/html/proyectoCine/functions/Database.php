<?php
class Database {
    private static $instance = null;
    private $connection;
    private function __construct() {
    $host = 'phpejercicios-db-1'; //Nombre del contenedor de BD
    $dbname = 'cinema'; // Nombre de la base de datos
    $username = 'cinema'; // Usuario que se va a conectar
    $password = 'cinema'; // Pasword del usuario
    try {
    $this->connection = new
    PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $this->connection->setAttribute(PDO::ATTR_ERRMODE,
    PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
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

