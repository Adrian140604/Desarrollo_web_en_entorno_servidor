<?php

// This function searches for a character in an array of data by name.
// If found, it returns the character's information; otherwise, it returns null.
function findCharacter($data, $name) {
    foreach ($data as $character) {
        // Compare the character's name with the name we're looking for.
        if ($character["nombre_persona"] === $name) {
            return $character; // Return the found character.
        }
    }
    return null; // If not found, return null.
}

// This function lists all characters from the database.
// It establishes a connection and executes an SQL query to get all characters.
function listCharacters($connection) {
    $query = "SELECT * FROM Personaje"; // SQL query to select all characters.
    $stmt = $connection->query($query); // Execute the query.
    $characters = $stmt->fetchAll(PDO::FETCH_ASSOC); // Get all results as an associative array.

    // Iterate over each character and generate a table row with their information.
    foreach ($characters as $character) {
        $characterNameEncoded = urlencode($character['nombre_persona']); // Encode the name for the URL.
        print "<tr>
                <td class=\"align-middle\">{$character['nombre_persona']}</td>
                <td class=\"text-end\">
                    <a class=\"btn btn-outline-primary my-1\" href=\"./formCharacters.php?formAction=showCharacter&characterName={$characterNameEncoded}\">View More</a>
            
                <a class=\"btn btn-outline-dark my-1\" href=\"./formCharacters.php?formAction=editCharacter&characterName={$characterNameEncoded}\">Editar</a>
                    <a class=\"btn btn-outline-danger my-1\" href=\"./formCharacters.php?formAction=deleteCharacter&characterName={$characterNameEncoded}\">Borrar</a>
                
            
                   
                
                </tr>"; // Create buttons to view, delete, or edit the character.
    }
}

// This function validates the action to be performed on a character.
// It ensures that the action is one of the allowed actions and redirects if not.
function validateCharacterAction($action) {
    // List of valid actions.
    $validActions = ["editCharacter", "deleteCharacter", "showCharacter", "addCharacter"];
    // Check if the action is defined and valid.
    if (!isset($action) || empty(trim($action)) || !in_array($action, $validActions)) {
        // Redirect to an error page if the action is not valid.
        print "<script>window.location.href = \"../error.php?msg=La acción que se desea realizar no es válida, por favor vuelva a intentarlo. Si el problema persiste contacte con el administrador de la página.&action=invalidAction\"</script>";
exit;

    }
    return htmlspecialchars(trim($action)); // Return the validated action.
}

// This function retrieves a specific character from the database by name.
function getCharacter($charName, $connection) {
    $query = "SELECT * FROM Personaje WHERE nombre_persona = :characterV"; // Query with a parameter.
    $stmt = $connection->prepare($query); // Prepare the query.
    $stmt->bindParam(':characterV', $charName); // Bind the parameter.
    $stmt->execute(); // Execute the query.
    $result = $stmt->fetch(PDO::FETCH_ASSOC); // Get the result.

    // If the character is not found, redirect to an error page.
    if (!$result) {
        header("Location: ./error.php?msg=El personaje elegido no existe");
        exit; // Stop the script execution.
    }

    return $result; // Return the character's information.
}

// This function adds a new character to the database.
// It checks if the required fields are filled and validates the inputs.
function addCharacter($conexion) {
    // Check if any of the required fields are empty.
    if (empty($_POST['character_name']) || empty($_POST['characterNationality']) || empty($_POST['characterGender'])) {
        return "Tienen que estar todos los campos rellenos"; // Return an error message.
    }

    // Validate that the character's name contains only letters and spaces.
    if (!preg_match("/^[a-zA-Z\s]+$/", $_POST['character_name'])) {
        return "El nombre solo puede contener letras y espacios."; // Return an error message.
    }

       // Verificar si el nombre del personaje ya existe en la base de datos.
    $checkQuery = "SELECT COUNT(*) FROM Personaje WHERE nombre_persona = :nombre_persona";
    $checkStmt = $conexion->prepare($checkQuery);
    $checkStmt->bindParam(':nombre_persona', $_POST['character_name']);
    $checkStmt->execute();
    $count = $checkStmt->fetchColumn();

    if ($count > 0) {
        return "Un personaje con ese nombre ya existe."; // Retornar un mensaje de error si el nombre ya existe.
    }

    // Define a list of allowed nationalities.
    $nacionalidadesPermitidas = [
        'Argentina', 'Brasil', 'Chile', 'México', 'España', 'Estados Unidos', 'Canadá',
        'Colombia', 'Perú', 'Venezuela', 'Ecuador', 'Uruguay', 'Paraguay', 'Bolivia',
        'Cuba', 'Puerto Rico', 'República Dominicana', 'Guatemala', 'Honduras', 'El Salvador',
        'Costa Rica', 'Panamá', 'Italia', 'Francia', 'Alemania', 'Reino Unido', 'Portugal',
        'Rusia', 'China', 'Japón', 'India', 'Australia', 'Nueva Zelanda', 'Sudáfrica',
        'Nigeria', 'Egipto', 'Turquía', 'Grecia', 'Suecia', 'Noruega', 'Finlandia', 'Polonia', 'Rumania'
    ];
    // Check if the nationality is in the list of allowed nationalities.
    if (!in_array($_POST['characterNationality'], $nacionalidadesPermitidas)) {
        return "La nacionalidad no es valida."; // Return an error message.
    }

    // Define a list of allowed genders.
    $generosPermitidos = ['M', 'F', 'O'];
    // Check if the gender is one of the allowed options.
    if (!in_array($_POST['characterGender'], $generosPermitidos)) {
        return "The gender must be 'M', 'F', or 'O'."; // Return an error message.
    }

    // Prepare an SQL query to insert a new character into the database.
    $query = "INSERT INTO Personaje (nombre_persona, nacionalidad_persona, sexo_persona) VALUES (:nombre_persona, :nacionalidad_persona, :sexo_persona)";
    $stmt = $conexion->prepare($query);
    
    // Execute the query with the provided character information.
    if ($stmt->execute([
        ':nombre_persona' => $_POST['character_name'],
        ':nacionalidad_persona' => $_POST['characterNationality'],
        ':sexo_persona' => $_POST['characterGender']
    ])) {
        return "El personaje se ha agregado correctamente."; // Return success message.
    } else {
        return "El personaje no se a podido agregar."; // Return error message if insertion fails.
    }
}

// This function updates an existing character's information in the database.
// This function updates an existing character's information in the database.
function updateCharacter($conexion, $name) {
    // Check if required fields are present
    if (empty($_POST['characterNationality']) || empty($_POST['characterGender'])) {
        return "Todos los campos deben estar rellenos."; // Return an error message.
    }

    // Define a list of allowed nationalities.
    $nacionalidadesPermitidas = [
        'Argentina', 'Brasil', 'Chile', 'México', 'España', 'Estados Unidos', 'Canadá',
        'Colombia', 'Perú', 'Venezuela', 'Ecuador', 'Uruguay', 'Paraguay', 'Bolivia',
        'Cuba', 'Puerto Rico', 'República Dominicana', 'Guatemala', 'Honduras', 'El Salvador',
        'Costa Rica', 'Panamá', 'Italia', 'Francia', 'Alemania', 'Reino Unido', 'Portugal',
        'Rusia', 'China', 'Japón', 'India', 'Australia', 'Nueva Zelanda', 'Sudáfrica',
        'Nigeria', 'Egipto', 'Turquía', 'Grecia', 'Suecia', 'Noruega', 'Finlandia', 'Polonia', 'Rumania'
    ];

    // Check if the nationality is valid
    if (!in_array($_POST['characterNationality'], $nacionalidadesPermitidas)) {
        return "La nacionalidad no es valida."; // Return an error message.
    }

    // Define a list of allowed genders.
    $generosPermitidos = ['M', 'F', 'O'];
    // Check if the gender is one of the allowed options.
    if (!in_array($_POST['characterGender'], $generosPermitidos)) {
        return "El genero debe ser  'M', 'F', or 'O'."; // Return an error message.
    }

    // Prepare the SQL query to update the character's nationality and gender.
    $query = "UPDATE Personaje SET
                nacionalidad_persona = :nacionalidad_persona,
                sexo_persona = :sexo_persona
              WHERE nombre_persona = :nombre_persona";

    $stmt = $conexion->prepare($query); // Prepare the query.
    
    // Execute the query with the new data for the character.
    $success = $stmt->execute([
        ':nacionalidad_persona' => $_POST['characterNationality'],
        ':sexo_persona' => $_POST['characterGender'],
        ':nombre_persona' => $name // Asegúrate de que $name contenga el nombre del personaje que se está actualizando.
    ]);

    return $success ? "Actualizacion exitosa" : "Error"; // Return success or error message.
}


// This function deletes a character from the database by name.
function deleteCharacter($connection, $name) {
    // Prepare an SQL query to delete the character.
    $query = "DELETE FROM Personaje WHERE nombre_persona = :characterName";
    $stmt = $connection->prepare($query); // Prepare the query.
    $stmt->bindParam(':characterName', $name); // Bind the parameter.
    return $stmt->execute(); // Execute the query and return true or false based on success.
}

// This function determines if certain actions should be disabled based on the action type.
function disabledOrNot($action) {
    // Return 'disabled' if the action is not 'editCharacter' or 'addCharacter'.
    return $action !== "editCharacter" && $action !== "addCharacter" ? 'disabled' : '';
}

// This function shows the appropriate form button based on the action type.
function showFormButton($action) {
    $button = '';
    $backButton = ""; // Initialize a variable for the back button
    switch ($action) {
        case "editCharacter":
            $backButton = '<a href="./showCharacterList.php" class="btn btn-secondary me-2">Volver</a>';

            // Button for saving changes when editing a character
            $button = '<input type="submit" class="btn btn-primary" value="Guardar Cambios">';
            break;
        case "deleteCharacter":
            // Back button that redirects to the character list or previous page
            $backButton = '<a href="./showCharacterList.php" class="btn btn-secondary me-2">Volver</a>';
            // Button for confirming the deletion of a character
            $button = '<input type="submit" class="btn btn-danger" value="Eliminar">';
            break;
        case "addCharacter":
            // Button for adding a new character
            $button = '<input type="submit" class="btn btn-primary" value="Añadir">';
            break;
        default:
            // Default action showing a back button to character list
            $button = '<a href="./showCharacterList.php" class="btn btn-primary">Volver</a>';
    }

    // Printing the buttons
    print "<div class=\"row mb-3\">
            <div class=\"col-md-6 offset-md-3 d-flex justify-content-end\">$backButton $button</div>
            </div>";
}

function showErrors($errors) {
    if (!empty($errors)) {
        echo '<div class="alert alert-danger" role="alert">';
        foreach ($errors as $error) {
            echo htmlspecialchars($error) . '<br>';
        }
        echo '</div>';
    }
}

/**
 * This function change the done message depending on the action
 * @param mixed $action
 * @return void
 */
function showDoneMessage($action) {
    $message = '';
    switch ($action) {
        case 'characterAdded':
            $message = 'Character added successfully!';
            break;
        case 'characterDeleted':
            $message = 'Character deleted successfully!';
            break;
        case 'characterUpdated':
            $message = 'Character updated successfully!';
            break;
    }
    if ($message) {
        echo '<div class="alert alert-success" role="alert">' . htmlspecialchars($message) . '</div>';
    }
}


