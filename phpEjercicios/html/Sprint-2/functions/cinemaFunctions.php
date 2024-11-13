<?php
/**
 * This function prints all cinemas stored in database with the format to insert in HTML table.
 * @param mixed $connection
 * @return void
 */
function listCinemas ($connection) {
    $query = "SELECT * FROM Cine"; // Query to execute in DB
    $stmt = $connection->query($query); // Return and storage query result
    $cinemas = $stmt->fetchAll(PDO::FETCH_ASSOC); // Convert query result in associative array
    foreach ($cinemas as $id => $cinema) { // Show all cinemas thats are in the array
      print "<tr>
            <td class=\"align-middle\">{$cinema["cine"]}</td>
            <td class=\"align-middle\">{$cinema["ciudad_cine"]}</td>
            <td class=text-end>
            <a class=\"btn btn-outline-warning my-1\" href=\"../rooms/showRoomsList.php?cinema={$cinema["cine"]}\">Ver salas</a>
            <a class=\"btn btn-outline-primary my-1\" href=\"./formCinemas.php?cinemaAction=showCinema&cinema={$cinema["cine"]}\">Ver más</a>
            <a class=\"btn btn-outline-dark my-1\" href=\"./formCinemas.php?cinemaAction=editCinema&cinema={$cinema["cine"]}\">Editar</a>
            <a class=\"btn btn-outline-danger my-1\" href=\"./formCinemas.php?cinemaAction=deleteCinema&cinema={$cinema["cine"]}\">Eliminar</a>
            </td>
            </tr>"; 
    }
}

/**
 * This function checks the action and if is valid return the action else change to error page.
 * @param mixed $action
 * @return string
 */
function validateCinemaAction ($action) { 
    if (isset($action) && !empty(trim($action)) && ($action === "editCinema" || $action === "deleteCinema" || $action === "showCinema" || $action === "addCinema")) { 
        return htmlspecialchars(trim($action));
    } else {
        print "<script>window.location.href = \"../error.php?msg=La acción que se desea realizar no es válida, por favor vuelva a intentarlo. Si el problema persiste contacte con el administrador de la página.&action=invalidAction\"</script>"; // If the action isn't valid change to error.php
        exit;
    }
}

/**
 * This function return all data stored about a cinema.
 * @param mixed $cinemaName
 * @param mixed $connection
 * @return mixed
 */
function getCinema ($cinemaName, $connection) { 
    $query = "SELECT * FROM Cine WHERE cine = :cinema"; // Query to execute in DB
    $stmt = $connection->prepare($query); // Prepare the query
    $stmt->bindParam(':cinema', $cinemaName); // Assing value to the params
    $stmt->execute(); // Execute the query
    $cinema = $stmt->fetch(PDO::FETCH_ASSOC); // Convert query result in associative array

    if (!$cinema) {
        print "<script>window.location.href = \"../error.php?msg=El cine seleccionado no existe, por favor vuelva a intentarlo. Si el problema persiste contacte con el administrador de la página.&action=invalidAction\"</script>"; // If cinema doesn't exist change the page to error.php
        exit;
    }

    return $cinema; // Return the information about the cinema.
}

/**
 * This function change the form title.
 * @param mixed $action
 * @return void
 */
function showFormTitle ($action) {
    switch ($action) {
        case "addCinema" :
            print "<h2 class=\"text-center mb-4\">Añadiendo nuevo cine</h2>";
            break;
        case "cinemaAdded" :
            print "<h2 class=\"text-center mb-4\">Cine añadido</h2>";
            break; 
        case "editCinema" :
            print "<h2 class=\"text-center mb-4\">Editando cine</h2>";
            break;
        case "cinemaUpdated" :
            print "<h2 class=\"text-center mb-4\">Cine actualizado</h2>";
            break;
        case "showCinema" :
            print "<h2 class=\"text-center mb-4\">Detalles del cine</h2>";
            break;
        case "deleteCinema" :
            print "<h2 class=\"text-center mb-4\">Eliminando cine</h2>";
            break;
        case "cinemaDeleted" :
            print "<h2 class=\"text-center mb-4\">Cine eliminado</h2>";
            break;
    }
}

/**
 * This function checks the action and if is different of "addCinema" print disabled (Is used on HTML inputs).
 * @param mixed $action
 * @return void
 */
function disabledOrNotPrimaryKey ($action) {
    if ($action != "addCinema") {
        print " disabled ";
    } 
}

/**
 * This function checks the action and if is different of "editCinema" and "addCinema" print disabled (Is used on HTML inputs).
 * @param mixed $action
 * @return void
 */
function disabledOrNot($action) { 
    if ($action != "editCinema" && $action != "addCinema") {
        print " disabled ";
    } 
}

/**
 * This function change the form button depending on the action.
 * @param mixed $action
 * @return void
 */
function showFormButton($action, $cinema) { 
    if ($action == "editCinema") { 
        print "<div class=\"row mb-3\">
                    <div class=\"col-md-6 offset-md-3 d-flex justify-content-end\">
                        <a href=\"./showCinemasList.php\"class=\"btn btn-outline-primary me-1\">Volver</a>
                        <input type=\"submit\" class=\"btn btn-primary\" value=\"Guardar Cambios\">
                    </div>
                </div>";
    } else if ($action == "cinemaUpdated") {
        print "<div class=\"row mb-3\">
                    <div class=\"col-md-6 offset-md-3 d-flex justify-content-end\">
                        <a href=\"./showCinemasList.php\"class=\"btn btn-primary\">Volver</a>
                    </div>
                </div>";
    } elseif ($action == "deleteCinema") {
        print "<div class=\"row mb-3\">
                    <div class=\"col-md-6 offset-md-3 d-flex justify-content-end\">
                        <a href=\"./showCinemasList.php\"class=\"btn btn-outline-danger me-1\">Cancelar</a>
                        <input type=\"submit\" class=\"btn btn-danger\" value=\"Confirmar eliminación\">
                    </div>
                </div>";
    } else if ($action == "cinemaDeleted") {
        print "<div class=\"row mb-3\">
                    <div class=\"col-md-6 offset-md-3 d-flex justify-content-end\">
                        <a href=\"./showCinemasList.php\"class=\"btn btn-primary\">Volver</a>
                    </div>
                </div>";
    } else if ($action == "showCinema") {
        print "<div class=\"row mb-3\">
                    <div class=\"col-md-3 offset-md-3 d-flex justify-content-start\">
                        <a class=\"btn btn-outline-dark my-1 me-1\" href=\"./formCinemas.php?cinemaAction=editCinema&cinema={$cinema["cine"]}\">Editar</a>
                        <a class=\"btn btn-outline-danger my-1\" href=\"./formCinemas.php?cinemaAction=deleteCinema&cinema={$cinema["cine"]}\">Eliminar</a>
                     </div>        
                    <div class=\"col-md-3 d-flex justify-content-end\">
                        <a href=\"./showCinemasList.php\"class=\"btn btn-primary my-1\">Volver</a>
                    </div>
                </div>";
    } else if ($action == "addCinema") { 
        print "<div class=\"row mb-3\">
                    <div class=\"col-md-6 offset-md-3 d-flex justify-content-end\">
                        <a href=\"./showCinemasList.php\"class=\"btn btn-outline-primary me-1\">Volver a la lista de cines</a>
                        <input type=\"submit\" class=\"btn btn-primary\" value=\"Añadir\">
                    </div>
                </div>";
    } else if ($action == "cinemaAdded") { 
        print "<div class=\"row mb-3\">
                    <div class=\"col-md-6 offset-md-3 d-flex justify-content-end\">
                        <a href=\"./showCinemasList.php\"class=\"btn btn-outline-primary me-1\">Ver la lista de cines</a>
                        <a href=\"./formCinemas.php?cinemaAction=addCinema\"class=\"btn btn-primary\">Añadir otro cine</a>
                    </div>
                </div>";
    }
}

/**
 * This function receives the new data and if the data is valid change it in the database.
 * @param mixed $cinemaName
 * @param mixed $updatedAge
 * @param mixed $updatedCity
 * @param mixed $updatedAddress
 * @param mixed $connection
 * @return bool
 */
function editCinema ($cinemaName, $updatedAge, $updatedCity, $updatedAddress, $connection) {
    $errors = validateInputData($cinemaName, $updatedAge, $updatedCity, $updatedAddress, $connection, "editCinema");

    if (count($errors) == 0) {
        $query = "UPDATE Cine SET ciudad_cine = :cityUpdated, direccion_cine = :addressUpdated, antiguedad = :ageUpdated WHERE cine = :cinema;"; // Query to execute in DB
        $stmt = $connection->prepare($query); // Prepare the query
        $stmt->bindParam(':cinema', $cinemaName); // Assing value to the params
        $stmt->bindParam(':cityUpdated', $updatedCity); // Assing value to the params
        $stmt->bindParam(':addressUpdated', $updatedAddress); // Assing value to the params
        $stmt->bindParam(':ageUpdated', $updatedAge); // Assing value to the params
        $stmt->execute(); // Execute the query
        return true;
        if ($stmt->rowCount() <= 0) {
            print "<script>window.location.href = \"../error.php?msg=Ocurrió un fallo al intentar editar el cine, por favor inténtelo de nuevo. Si el problema persiste contacte con el administrador de la página.\"</script>"; // If the query didn't edit any row change the page to error.php
            exit;
        }
    } else {
        return false;
    }


}

/**
 * This function add a cinema to the database.
 * @param mixed $cinemaName
 * @param mixed $cinemaAge
 * @param mixed $cinemaCity
 * @param mixed $cinemaAddress
 * @param mixed $connection
 * @return bool
 */
function addCinema ($cinemaName, $cinemaAge, $cinemaCity, $cinemaAddress, $connection) {
    $errors = validateInputData($cinemaName, $cinemaAge, $cinemaCity, $cinemaAddress, $connection, "addCinema");
    if (count($errors) == 0) {
        $query = "INSERT INTO Cine(cine, ciudad_cine, direccion_cine, antiguedad) VALUES (:newCinema, :newCity, :newAddress, :newAge);"; // Query to execute in DB
        $stmt = $connection->prepare($query); // Prepare the query
        $stmt->bindParam(':newCinema', $cinemaName); // Assing value to the params
        $stmt->bindParam(':newCity', $cinemaCity); // Assing value to the params
        $stmt->bindParam(':newAddress', $cinemaAddress); // Assing value to the params
        $stmt->bindParam(':newAge', $cinemaAge, PDO::PARAM_INT); // Assing value to the params
        $stmt->execute(); // Execute the query
        return true;
        if ($stmt->rowCount() <= 0) {
            print "<script>window.location.href = \"../error.php?msg=Ocurrió un fallo al intentar añadir el cine, por favor inténtelo de nuevo. Si el problema persiste contacte con el administrador de la página.\"</script>"; // If the query didn't edit any row change the page to error.php
            exit;
        }
    } 
    return false;
}

/**
 * This function validates if the data of a cinema is valid according to the requirements.
 * @param mixed $cinemaName
 * @param mixed $cinemaAge
 * @param mixed $cinemaCity
 * @param mixed $cinemaAddress
 * @param mixed $connection
 * @param mixed $action
 * @return array
 */
function validateInputData ($cinemaName, $cinemaAge, $cinemaCity, $cinemaAddress, $connection, $action) {
    $errors = []; // In this array we storage the errors.
    $query = "SELECT * FROM Cine WHERE cine = :newCinema"; // Query to execute in DB
    $stmt = $connection->prepare($query); // Prepare the query
    $stmt->bindParam(':newCinema', $cinemaName); // Assing value to the params
    $stmt->execute(); // Execute the query
    if (($stmt->rowCount() > 0 && $action == "addCinema")) {
        array_push($errors, "El cine que se está intentando añadir ya existe");
    }
    if (!isset($cinemaName) || empty($cinemaName) || strlen($cinemaName) > 25) {
        array_push($errors, "El nombre no puede estar vacío y debe tener como máximo 25 caracteres");
    }
    if (!isset($cinemaCity) || empty($cinemaCity) || strlen($cinemaCity) > 25) {
        array_push($errors, "Debe introducir la ciudad y debe tener como máximo 25 caracteres");
    }
    if (strlen($cinemaAddress) > 65) {
        array_push($errors, "La dirección debe tener como máximo 65 caracteres");
    }

    $query = "SELECT * FROM Cine WHERE direccion_cine = :newAddress"; // Query to execute in DB
    $stmt = $connection->prepare($query); // Prepare the query
    $stmt->bindParam(':newAddress', $cinemaAddress); // Assing value to the params
    $stmt->execute(); // Execute the query
    $cinema = $stmt->fetch(PDO::FETCH_ASSOC); // Convert query result in associative array
    if ($stmt->rowCount() > 0 && $cinema["cine"] != $cinemaName) {
        array_push($errors, "Ya existe un cine en la dirección proporcionada");
    }

    if (!is_numeric($cinemaAge) || $cinemaAge <= 0) {
        array_push($errors, "La antigüedad debe ser un número mayor que 0");
    }

    return $errors;
} 

/**
 * This function prints the errors with HTML list format.
 * @param mixed $errors
 * @return void
 */
function showErrors ($errors) {
    print "<div class=\"col-md-4 offset-md-4 alert alert-danger mt-4 text-center\">";
    foreach ($errors as $error) {
        print "<li>{$error}</li>";
    }
    print "</ul></div>";
}

/**
 * This function change the done message depending on the action
 * @param mixed $action
 * @return void
 */
function showDoneMessage ($action) {
    print "<div class=\"col-md-4 offset-md-4 alert alert-success mt-4 text-center\">";
    if ($action == "cinemaAdded") {
        print "<h5 class=\"alert-heading\">Añadido con éxito</h5>";
        print "<p>El cine ha sido añadido con éxito</p>";
    } else if ($action == "cinemaUpdated") {
        print "<h5 class=\"alert-heading\">Actualizado con éxito</h5>";
        print "<p>El cine ha sido actualizado con éxito</p>";
    } else if ($action == "cinemaDeleted") {
        print "<h5 class=\"alert-heading\">Eliminado con éxito</h5>";
        print "<p>El cine ha sido eliminado con éxito</p>";
    }
    print "</div>";

} 

/**
 * This function delete from the database the cinema
 * @param mixed $cinemaName
 * @param mixed $connection
 * @return void
 */
function deleteCinema ($cinemaName, $connection) {
    $query = "DELETE FROM Cine WHERE cine = :deleteCinema"; // Query to execute in DB
    $stmt = $connection->prepare($query); // Prepare the query
    $stmt->bindParam(':deleteCinema', $cinemaName); // Assing value to the params
    $stmt->execute(); // Execute the query
    if ($stmt->rowCount() <= 0) {
        print "<script>window.location.href = \"../error.php?msg=Ocurrió un fallo al intentar añadir el cine, por favor inténtelo de nuevo. Si el problema persiste contacte con el administrador de la página.\"</script>"; // If the query didn't edit any row change the page to error.php
        exit;
    }
}
