<?php
require_once("./ProyectoCine/database_cine.php");
$conexion= Database::getInstance()->getConnection(); 
function eliminarTarea($tarea,$conexion){
    $query="DELETE FROM Tarea WHERE tarea = $tarea";
    $conexion->query($query);
}

function crearTarea($tarea,$sexoTarea,$salarioBase,$conexion){
    // Prepare the SQL query using prepared statements to avoid SQL injection
    $query = "INSERT INTO Tarea (tarea,sexo_tarea, salario_base) 
                VALUES (:tarea,:sexo_tarea, :salario_base)";

    // Prepare and bind parameters
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(':tarea', $tarea, PDO::PARAM_STR);
    $stmt->bindParam(':sexo_tarea', $sexoTarea, PDO::PARAM_STR);
    $stmt->bindParam(':salario_base', $salarioBase, PDO::PARAM_INT);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Tarea creada exitosamente.";
    } else {
        echo "Error al crear la tarea: " . $stmt->errorInfo()[2];
    }
}

function borrarTarea($tarea,$conexion){
    $query="DELETE FROM Tarea WHERE tarea = $tarea";
    $conexion->query($query);
}

function getTarea($tarea, $conexion) {
    $query = "SELECT * FROM Tarea WHERE tarea = :tarea";
    $stmt = $conexion->prepare($query);

    $stmt->bindParam(':tarea', $tarea, PDO::PARAM_INT);
    $stmt->execute();
    $tareaBuscar = $stmt->fetch(PDO::FETCH_ASSOC);
    return $tareaBuscar;
}




?>