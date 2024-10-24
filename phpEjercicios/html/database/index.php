<?php
$host = 'phpejercicios-db-1';
$dbname = 'toor'; //Nombre de la base de datos
$user = 'adrian'; //Nombre del usuario
$pass = 'adrian'; //Password del usuario
$port = 3306;
try {
// Crear una instancia de PDO para la conexión con SSL habilitado
$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
$options = [
PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Manejo de errores
PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Modo de recuperación
PDO::ATTR_EMULATE_PREPARES => false, // Desactiva la emulación de sentencias preparadas
];
// Conectar a la base de datos
$pdo = new PDO($dsn, $user, $pass, $options);
// echo "Conexión exitosa a la base de datos.";
} catch (PDOException $e) {
// Captura cualquier error en la conexión
die("Error de conexión: " . $e->getMessage());
}?>

<h1>Te has conectado</h1>