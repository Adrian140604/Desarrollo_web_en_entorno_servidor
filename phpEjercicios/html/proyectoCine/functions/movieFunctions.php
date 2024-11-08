<?php
// Function to list movies
function listmovie($connection) {
    // SQL query to get all movies from the database
    $query = "SELECT * FROM Pelicula";
    // Execute the query
    $stmt = $connection->query($query);
    // Fetch all movies as an associative array
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Loop to show each movie in a table row
    foreach ($movies as $id => $movie) {
        print "<tr>
                <td class=\"align-middle\">{$movie["titulo_p"]}</td>
                <td class=\"text-end\">    
                    <a class=\"btn btn-outline-primary my-1\" href=\"formMovies.php?accion=vermas&cip={$movie["cip"]}\">Ver más</a>
                    <a class=\"btn btn-outline-dark my-1\" href=\"formMovies.php?accion=editar&cip={$movie["cip"]}\">Editar</a> 
                    <a class=\"btn btn-outline-danger my-1\" href=\"formMovies.php?accion=eliminar&cip={$movie["cip"]}\">Eliminar</a> 
                </td>
               </tr>";
    }
}

// Function to view a custom title depending on the action
function viewTitle($accion, $deleted = false) {
    // If movie is deleted, show this message
    if ($deleted) {
        return "Película eliminada exitosamente";
    }
    // Check the action and return the proper title for each action
    switch ($accion) {
        case 'add':
            return "Formulario de Agregar Película";
        case 'editar':
            return "Formulario de Editar Película";
        case 'vermas':
            return "Detalles de la Película";
        case 'eliminar':
            return "Formulario de Eliminar Película";
        default:
            return "Formulario de Película";
    }
}

// Function to get a specific movie by its cip (primary key)
function getMovie($connection, $cip) {
    $query = "SELECT * FROM Pelicula WHERE cip = :cip";
    $stmt = $connection->prepare($query);
    // Bind the cip parameter and execute the query
    $stmt->bindParam(':cip', $cip, PDO::PARAM_STR);
    $stmt->execute();

    // Return movie details as an associative array
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Function to check if a movie with the same title and production year already exists

function repeatMovie($title, $year, $connection) {
    // Create the SQL query to check for duplicate movies
    $sql = "SELECT COUNT(*) FROM Pelicula WHERE titulo_p = :title AND ano_produccion = :year";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':year', $year);
    
    // Execute the query
    $stmt->execute();
    
    // Return true if a duplicate exists, false otherwise
    return $stmt->fetchColumn() > 0;
}

function checkDuplicateId($cip, $connection) {
    // Check if a movie with the same ID exists in the database
    $query = "SELECT * FROM Pelicula WHERE cip = :cip";
    $stmt = $connection->prepare($query);
    $stmt->bindParam(':cip', $cip);
    $stmt->execute();
    return $stmt->rowCount() > 0; // Return true if any rows were found
}




// Function to validate the production year
function ageproduction($age){
    // Check if the year is negative or not a number
    if ($age < 0 || !is_numeric($age)) {
        $errorMsg = "Error: No se puede crear con un año menor a 0 o que no sea numérico.";
        echo "<script>window.location.replace('error.php?msg=" . urlencode($errorMsg) . "');</script>";
        return true;
    } else {
        return false;
    }
}

// Function to disable form fields if action is 'vermas' or 'eliminar'
function viewDisabled($accion){
    if($accion === "vermas"){
        echo "disabled";
    } elseif($accion === "eliminar"){
        echo "disabled";
    }
}

// Function to disable primary key field if action is not 'add'
function viewdisabledprimarykey($accion){
    if($accion != "add"){
        echo "disabled";
    }
}

// Function to display buttons based on the action
function viewButton($accion) {
    if ($accion === "vermas") {
        echo "
            <div class=\"col-md-6 offset-md-3 d-flex justify-content-end\">
                <a href=\"showMoviesList.php\" class=\"btn btn-primary\">Volver</a>
            </div>";
    } elseif ($accion === "editar") {
        echo "
            <div class=\"col-md-6 offset-md-3 d-flex justify-content-end\">
                <a href=\"./showMoviesList.php\"class=\"btn btn-outline-primary me-1\">Cancelar</a>
                <button type=\"submit\" name=\"edit\" class=\"btn btn-primary\">Confirmar</button>
            </div>";
    } elseif ($accion === "eliminar") {
        echo "
            <div class=\"col-md-6 offset-md-3 d-flex justify-content-end\">
            <a href=\"./showMoviesList.php\"class=\"btn btn-outline-danger me-1\">Cancelar</a>
               <button type=\"submit\" name=\"delete\" class=\"btn btn-danger\">Confirmar Eliminación</button>
            </div>";
    } elseif ($accion === "add") {
        echo "
            <div class=\"col-md-6 offset-md-3 d-flex justify-content-end\">
                <button type=\"submit\" class=\"btn btn-primary\">Añadir</button>
            </div>";
    }
}

// Function to add a new movie to the database
function addMovie($cip,$titulo, $anoProduccion, $tituloSecundario, $nacionalidad, $presupuesto, $duracion, $connection) {
    $query = "INSERT INTO Pelicula (cip, titulo_p, ano_produccion, titulo_s, nacionalidad, presupuesto, duracion) 
              VALUES (:cip, :titulo, :anoProduccion, :tituloSecundario, :nacionalidad, :presupuesto, :duracion)";
    $stmt = $connection->prepare($query);

    // Bind each parameter to its value
    $stmt->bindParam(':cip', $cip);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':anoProduccion', $anoProduccion);
    $stmt->bindParam(':tituloSecundario', $tituloSecundario);
    $stmt->bindParam(':nacionalidad', $nacionalidad);
    $stmt->bindParam(':presupuesto', $presupuesto);
    $stmt->bindParam(':duracion', $duracion);

    $stmt->execute();
}



// Function to delete a movie based on its cip
function deleteMovie($cip, $connection) {
    $query = "DELETE FROM Pelicula WHERE cip = :cip";
    $stmt = $connection->prepare($query);
    $stmt->bindParam(':cip', $cip);
    $stmt->execute();
}

// Function to edit movie details
function editMovie($cip, $titulo, $anoProduccion, $tituloSecundario, $nacionalidad, $presupuesto, $duracion, $connection) {
    $query = "UPDATE Pelicula 
              SET titulo_p = :titulo, 
                  ano_produccion = :anoProduccion, 
                  titulo_s = :tituloSecundario, 
                  nacionalidad = :nacionalidad, 
                  presupuesto = :presupuesto, 
                  duracion = :duracion 
              WHERE cip = :cip";
    $stmt = $connection->prepare($query);

    $stmt->bindParam(':cip', $cip);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':anoProduccion', $anoProduccion);
    $stmt->bindParam(':tituloSecundario', $tituloSecundario);
    $stmt->bindParam(':nacionalidad', $nacionalidad);
    $stmt->bindParam(':presupuesto', $presupuesto);
    $stmt->bindParam(':duracion', $duracion);

    echo $stmt->execute();
}
?>
