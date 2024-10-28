<?php
require_once("Database.php");
$conexion= Database::getInstance()->getConnection();
?>
Conexion exitosa
<br>
<?php
 $query= "SELECT * FROM Cliente";
 $smt= $conexion->query($query);
 $clientes = $smt -> fetchAll(PDO::FETCH_ASSOC);
 foreach( $clientes as $row ) {
    echo "Apellido: $row[apellido], Nombre: $row[nombre], Email: $row[email], Genero: $row[genero],Direccion: $row[direccion], ID: $row[id]";
    echo "<br/>";

 }
?>