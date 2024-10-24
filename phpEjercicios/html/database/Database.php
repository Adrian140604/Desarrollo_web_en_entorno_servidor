<?php
class Database {
    private static $instance = null;
    private $connection;
    private function __construct() {
        $host = 'phpejercicios-db-1';
        $dbname = 'toor'; //Nombre de la base de datos
        $user = 'adrian'; //Nombre del usuario
        $pass = 'adrian'; //Password del usuario
        $port = 3306;
    try {
    $this->connection = new
    PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
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
?>
<h1>Te has conectado</h1>