<?php

function findProjection($db, $cinema, $room, $date, $cip) {
    $dateParam=date('Y-m-d', strtotime($date));
    $query = "SELECT * FROM Proyeccion WHERE cine = :cine AND sala=:sala 
    AND fecha_estreno=:fecha_estreno AND cip=:cip";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':cine', $cinema, PDO::PARAM_STR);
    $stmt->bindParam(':sala', $room, PDO::PARAM_INT);
    $stmt->bindParam(':fecha_estreno', $dateParam);
    $stmt->bindParam(':cip', $cip, PDO::PARAM_STR);


    try {
        $stmt->execute(); 
    } catch (PDOException $e) {
        echo "<script>window.location.href = '../../cinema-php-2425-sprint-2-grupo-6/error.php?msg=Error al buscar la proyección';</script>";
        return null;
    }

    $projection = $stmt->fetch(PDO::FETCH_ASSOC); 

    if ($projection) {
        return $projection;
    } else {
        echo "<script>window.location.href = '../../cinema-php-2425-sprint-2-grupo-6/error.php?msg=La proyección no es válida';</script>";
        
        return null;
    }
}


function deleteProjection($db, $cinema, $room, $date, $cip): mixed {
    $proyeccion = findProjection($db, $cinema, $room, $date, $cip);
    $dateParam=date('Y-m-d', strtotime($date));
    $query = "DELETE FROM Proyeccion WHERE cine = :cine AND sala=:sala 
    AND fecha_estreno=:fecha_estreno AND cip=:cip";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':cine', $cinema, PDO::PARAM_STR);
    $stmt->bindParam(':sala', $room, PDO::PARAM_INT);
    $stmt->bindParam(':fecha_estreno', $dateParam);
    $stmt->bindParam(':cip', $cip, PDO::PARAM_STR);


    
    try {
        $stmt->execute(); 
    } catch (PDOException $e) {
        echo "<script>window.location.href = '../../cinema-php-2425-sprint-2-grupo-6/error.php?msg=Error en la consulta';</script>";
        return null;
    }

    if ($stmt->rowCount() > 0) { // If a row was affected, screening was deleted
        return $proyeccion; 
    } else {
        echo "<script>window.location.href = '../../cinema-php-2425-sprint-2-grupo-6/error.php?msg=Error al eliminar la proyección';</script>";
        return null;
    }
}


