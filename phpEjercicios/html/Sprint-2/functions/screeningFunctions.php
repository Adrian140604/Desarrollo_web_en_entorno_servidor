<?php

function findScreening($db, $cinema, $room, $date, $cip) {
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
    }
}


function deleteScreening($db, $cinema, $room, $date, $cip): mixed {
    $proyeccion = findScreening($db, $cinema, $room, $date, $cip);
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


function validateScreening($action) {
    // List of valid actions.
    $validActions = ["editScreening", "deleteScreening", "showScreening", "addScreening"];
    // Check if the action is defined and valid.
    if (!isset($action) || empty(trim($action)) || !in_array($action, $validActions)) {
        // Redirect to an error page if the action is not valid.
        print "<script>window.location.href = \"../error.php?msg=La acción que se desea realizar no es válida, por favor vuelva a intentarlo. Si el problema persiste contacte con el administrador de la página.&action=invalidAction\"</script>";
exit;

    }
    return htmlspecialchars(trim($action)); // Return the validated action.
}




function showFormTitle ($action) {
    switch ($action) {
        case "addScreening" :
            print "<h2 class=\"text-center mb-4\">Añadiendo nueva proyección</h2>";
            break;
        case "ScreeningAdded" :
            print "<h2 class=\"text-center mb-4\">Proyección añadida</h2>";
            break; 
        case "editScreening" :
            print "<h2 class=\"text-center mb-4\">Editando proyección</h2>";
            break;
        case "ScreeningUpdated" :
            print "<h2 class=\"text-center mb-4\">Proyección actualizada</h2>";
            break;
        case "showScreening" :
            print "<h2 class=\"text-center mb-4\">Detalles del proyección</h2>";
            break;
        case "deleteScreening" :
            print "<h2 class=\"text-center mb-4\">Eliminando proyección</h2>";
            break;
        case "ScreeningDeleted" :
            print "<h2 class=\"text-center mb-4\">Proyección eliminado</h2>";
            break;
    }
}



function showDoneMessage ($action) {
    print "<div class=\"col-md-4 offset-md-4 alert alert-success mt-4 text-center\">";
    if ($action == "screeningAdded") {
        print "<h5 class=\"alert-heading\">Añadido con éxito</h5>";
        print "<p>La proyección ha sido añadido con éxito</p>";
    } else if ($action == "screeningUpdated") {
        print "<h5 class=\"alert-heading\">Actualizado con éxito</h5>";
        print "<p>La proyección ha sido actualizada con éxito</p>";
    } else if ($action == "screeningDeleted") {
        print "<h5 class=\"alert-heading\">Eliminado con éxito</h5>";
        print "<p>La proyección ha sido eliminada con éxito</p>";
    }
    print "</div>";

} 

function showErrors ($errors) {
    print "<div class=\"col-md-4 offset-md-4 alert alert-danger mt-4 text-center\">";
    foreach ($errors as $error) {
        print "<li>{$error}</li>";
    }
    print "</ul></div>";
}

function disabledOrNot($action) { 
    if ($action != "editScreening" && $action != "addScreening") {
        print " disabled ";
    } 
}

function disabledOrNotPrimaryKey ($action) {
    if ($action != "addScreening") {
        print " disabled";
    } 
}


function showFormButton($action, $screening) { 
    if ($action == "editScreening") { 
        print "<div class=\"row mb-3\">
                    <div class=\"col-md-6 offset-md-3 d-flex justify-content-end\">
                        <a href=\"./showScreeningList.php\"class=\"btn btn-outline-primary me-1\">Volver</a>
                        <input type=\"submit\" class=\"btn btn-primary\" value=\"Guardar Cambios\">
                    </div>
                </div>";
    } else if ($action == "screeningUpdated") {
        print "<div class=\"row mb-3\">
                    <div class=\"col-md-6 offset-md-3 d-flex justify-content-end\">
                        <a href=\"./showScreeningList.php\"class=\"btn btn-primary\">Volver</a>
                    </div>
                </div>";
    } elseif ($action == "deleteScreening") {
        print "<div class=\"row mb-3\">
                    <div class=\"col-md-6 offset-md-3 d-flex justify-content-end\">
                        <a href=\"./showScreeningList.php\"class=\"btn btn-outline-danger me-1\">Cancelar</a>
                        <input type=\"submit\" class=\"btn btn-danger\" value=\"Confirmar eliminación\">
                    </div>
                </div>";
    } else if ($action == "screeningDeleted") {
        print "<div class=\"row mb-3\">
                    <div class=\"col-md-6 offset-md-3 d-flex justify-content-end\">
                        <a href=\"./showScreeningList.php\"class=\"btn btn-primary\">Volver</a>
                    </div>
                </div>";
    } else if ($action == "showScreening") {

        print "<div class=\"row mb-3\">
                    <div class=\"col-md-3 offset-md-3 d-flex justify-content-start\">
                        <a class=\"btn btn-outline-dark my-1 me-1\" href=\"./formScreenings.php?screeningAction=editScreening&cine={$screening['cine']}&sala={$screening['sala']}&cip={$screening['cip']}&fecha_estreno={$screening['fecha_estreno']}\">Editar</a>
                        <a class=\"btn btn-outline-danger my-1\" href=\"./formScreenings.php?screeningAction=deleteScreening&cine={$screening['cine']}&sala={$screening['sala']}&cip={$screening['cip']}&fecha_estreno={$screening['fecha_estreno']}\">Eliminar</a>

                     </div>        
                    <div class=\"col-md-3 d-flex justify-content-end\">
                        <a href=\"./showScreeningList.php\"class=\"btn btn-primary my-1\">Volver</a>
                    </div>
                </div>";
    } else if ($action == "addScreening") { 
        print "<div class=\"row mb-3\">
                    <div class=\"col-md-6 offset-md-3 d-flex justify-content-end\">
                        <a href=\"./showScreeningList.php\"class=\"btn btn-outline-primary me-1\">Volver a la lista de proyecciones</a>
                        <input type=\"submit\" class=\"btn btn-primary\" value=\"Añadir\">
                    </div>
                </div>";
    } else if ($action == "screeningAdded") { 
        print "<div class=\"row mb-3\">
                    <div class=\"col-md-6 offset-md-3 d-flex justify-content-end\">
                        <a href=\"./showScreeningList.php\"class=\"btn btn-outline-primary me-1\">Ver la lista de proyecciones</a>
                        <a href=\"./formScreenings.php?ScreeningAction=addScreening\"class=\"btn btn-primary\">Añadir otra proyección</a>
                    </div>
                </div>";
    }
}

function listScreenings ($connection) {
    $query = "SELECT * FROM Proyeccion"; // Query to execute in DB
    $stmt = $connection->query($query); // Return and storage query result
    $screenings = $stmt->fetchAll(PDO::FETCH_ASSOC); // Convert query result in associative array
    foreach ($screenings as $id => $screening) { // Show all cinemas thats are in the array
      print "<tr>
            <td class=\"align-middle\">{$screening["cine"]}</td>
            <td class=\"align-middle\">{$screening["sala"]}</td>
            <td class=\"align-middle\">{$screening["cip"]}</td>
            <td class=\"align-middle\">{$screening["fecha_estreno"]}</td>

            <td class=text-end>
          
            <a class=\"btn btn-outline-primary my-1\" href=\"./formScreenings.php?screeningAction=showScreening&cine={$screening['cine']}&sala={$screening['sala']}&cip={$screening['cip']}&fecha_estreno={$screening['fecha_estreno']}\">Ver más</a>
            <a class=\"btn btn-outline-dark my-1\" href=\"./formScreenings.php?screeningAction=editScreening&cine={$screening['cine']}&sala={$screening['sala']}&cip={$screening['cip']}&fecha_estreno={$screening['fecha_estreno']}\">Editar</a>
            <a class=\"btn btn-outline-danger my-1\" href=\"./formScreenings.php?screeningAction=deleteScreening&cine={$screening['cine']}&sala={$screening['sala']}&cip={$screening['cip']}&fecha_estreno={$screening['fecha_estreno']}\">Eliminar</a>

            </td>
            </tr>"; 
    }
}

function showCast($connection) {
    $cinema=$_GET["cine"];
    $room=$_GET["sala"];
    $cip=$_GET["cip"];
    $release_date=$_GET["fecha_estreno"];

    $query = "SELECT t.tarea, t.nombre_persona FROM Trabajo t, Pelicula p WHERE t.cip = p.cip AND p.cip=:cip";
    $stmt = $connection->prepare($query);
    $stmt->bindParam(':cip', $cip);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // Cambiado a fetchAll para obtener todas las filas

    // Verificamos si hay resultados
    if ($result) {
        foreach ($result as $character) {
            print "<tr>
                  <td class=\"align-middle\">{$character['t.tarea']}</td>
                  <td class=\"align-middle\">{$character['t.nombre_persona']}</td>
                  <td class=\"text-end\"></td>

                  </tr>";
        }
        print "<a class=\"btn btn-outline-primary my-1\" href=\"./showScreeningList.php\">Volver</a> ";
    } else {
        print "<tr><td colspan='4' class='text-center'>No se encontraron registros</td></tr>";
    }
}

function getAforo($cine,$cip,$sala,$fecha_estreno,$connection) { // Usamos la conexión PDO global

    // Preparar la consulta SQL para obtener todas las salas
    $sql = "SELECT s.aforo FROM Sala s,Proyeccion pr WHERE s.cine = pr.cine AND s.sala = pr.sala AND pr.cine = :cine AND pr.cip = :cip AND pr.sala = :sala and pr.fecha_estreno = :fecha_estreno;";
    $stmt = $connection->prepare($sql);  // Preparamos la consulta
    $stmt->bindParam(':cine', $cine); // Assing value to the params
    $stmt->bindParam(':cip', $cip); // Assing value to the params
    $stmt->bindParam(':sala', $sala,PDO::PARAM_INT); // Assing value to the params
    $stmt->bindParam(':fecha_estreno', $fecha_estreno); // Assing value to the params
    // Ejecutar la consulta
    $stmt->execute();

    // Obtener todos los resultados y almacenarlos en un array
    $aforo = $stmt->fetch(PDO::FETCH_ASSOC);

    return $aforo;  // Devolvemos el array con todas las salas
}


function editScreening($connection, $sala, $aforo, $cine) {
    // Primero actualizamos la proyección en la tabla Proyeccion
    $sql_proyeccion = "UPDATE Proyeccion SET sala = :sala WHERE cine = :cine AND sala = :sala_actual";
    
    // Preparamos la sentencia para la tabla Proyeccion
    $stmt_proyeccion = $connection->prepare($sql_proyeccion);
    $stmt_proyeccion->bindParam(':sala', $sala, PDO::PARAM_INT);
    $stmt_proyeccion->bindParam(':cine', $cine, PDO::PARAM_STR);
    $stmt_proyeccion->bindParam(':sala_actual', $sala, PDO::PARAM_INT);  // Sala original antes de la actualización

    // Ejecutamos la consulta para actualizar la proyección
    $proyeccion_result = $stmt_proyeccion->execute();

    // Si no se actualizó correctamente la proyección, retornamos false
    if (!$proyeccion_result) {
        return false;
    }

    // Luego actualizamos el aforo en la tabla Sala
    $sql_sala = "UPDATE Sala SET aforo = :aforo WHERE cine = :cine AND sala = :sala";
    
    // Preparamos la sentencia para la tabla Sala
    $stmt_sala = $connection->prepare($sql_sala);
    $stmt_sala->bindParam(':aforo', $aforo, PDO::PARAM_INT);  // Aquí actualizamos el aforo
    $stmt_sala->bindParam(':sala', $sala, PDO::PARAM_INT);
    $stmt_sala->bindParam(':cine', $cine, PDO::PARAM_INT);

    // Ejecutamos la consulta para actualizar el aforo
    $sala_result = $stmt_sala->execute();

    // Si ambas consultas se ejecutaron correctamente, retornamos true
    return $sala_result;
}



function addScreening($connection) {
    // Preparar consulta para insertar proyección
    $query = "INSERT INTO Proyeccion (cine, sala, cip, fecha_estreno, dias_estreno, espectadores, recaudacion)
     VALUES (:cine, :sala, :cip, :fecha_estreno, :dias_estreno, :espectadores, :recaudacion) ";

    $stmt = $connection->prepare($query);
    $stmt->bindParam(':cine', $_POST['cine'], PDO::PARAM_STR);
    $stmt->bindParam(':sala', $_POST['sala'], PDO::PARAM_INT);
    $stmt->bindParam(':cip',$_POST['cip'], PDO::PARAM_STR);
    $stmt->bindParam(':fecha_estreno',$_POST['release-date']);
    $stmt->bindParam(':dias_estreno',$_POST['release-days'],PDO::PARAM_INT);
    $stmt->bindParam(':espectadores',$_POST['spectators'],PDO::PARAM_INT);
    $stmt->bindParam(':recaudacion',$_POST['collection'],PDO::PARAM_INT);

    // Ejecutar la consulta y comprobar el resultado
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function getCinemas($connection) {
    $query = "SELECT cine FROM Cine";
    $result = $connection->query($query);
    if ($result) {
        $cinemas = $result->fetchAll(PDO::FETCH_ASSOC);
    }
    return $cinemas;
}

function getRooms($connection) {
    $query = "SELECT DISTINCT sala FROM Sala s";
    $result = $connection->query($query);
    if ($result) {
        $rooms = $result->fetchAll(PDO::FETCH_ASSOC);
    }
    return $rooms;
}

function getMovies($connection) {
    $query = "SELECT cip FROM Pelicula";
    $result = $connection->query($query);
    if ($result) {
        $movies = $result->fetchAll(PDO::FETCH_ASSOC);
    }
    return $movies;
}





