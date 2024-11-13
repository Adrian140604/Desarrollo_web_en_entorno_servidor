<?php
require("./../components/header.php");
require("./../functions/Database.php");
$connection = Database::getInstance()->getConnection();
require("./../functions/characterFunctions.php");

// Get the character name from the URL if it exists.
if (isset($_GET['characterName'])) {
    $characterName = urldecode($_GET['characterName']); // Decode the character name.
    $character = getCharacter($characterName, $connection); // Retrieve character details.
} else {
    $character = null; // If no character name is provided, set to null.
}

// Determine the action to perform based on the URL parameter.
$formAction = $_GET['formAction'] ?? '';
$formAction = validateCharacterAction($formAction); // Llamada a la función de validación.

$showMessage = false; // Initialize the showMessage variable.
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle adding a character.
    if ($formAction === 'addCharacter') {
        $result = addCharacter($connection); // Call the function to add character.
        if ($result === true) {
            $formAction = 'characterAdded'; // Change action to indicate success.
            $showMessage = true; // Set to show the message.
        } else {
            $errors[] = $result; // Store the error message if adding fails.
        }
    }
    // Handle deleting a character.
    else if ($formAction === 'deleteCharacter') {
        if (deleteCharacter($connection, $_GET['characterName'])) {
            $formAction = 'characterDeleted'; // Change action to indicate success.
            $showMessage = true; // Set to show the message.
        } else {
            $errors[] = "Failed to delete the character."; // Store the error message.
        }
    }
    // Handle updating a character.
    else if ($formAction === 'editCharacter') {
        $result = updateCharacter($connection, $characterName);
        
        if (strpos($result, 'Actualizacion exitosa') !== false) {
            $formAction = 'characterUpdated'; // Change action to indicate success.
            $showMessage = true; // Show the success message.
            $character = getCharacter($characterName, $connection); // Refresh character details.
        } else {
            $errors[] = $result; // Store the error message.
            $showMessage = false; // Don't show a success message.
        }
    }
    else if ($formAction === 'showFilmography') {
        if (showFilmography($_GET['characterName'],$connection )) {
            $formAction = 'characterFimpgraphyShow'; // Change action to indicate success.
            $showMessage = true; // Set to show the message.
        } else {
            $errors[] = "Failed to delete the character."; // Store the error message.
        }
    }
}
?>

<!-- Character form for adding or editing a character -->
<form class="container mt-4" method="post">
    <div class="mb-3">
        <label for="characterName" class="form-label">Name:</label>
        <input type="text" class="form-control" name="character_name" id="characterName" 
               value="<?php echo htmlspecialchars($character['nombre_persona'] ?? ''); ?>" 
               <?php echo $formAction === 'addCharacter' ? '' : 'readonly'; ?>>
    </div>

    <div class="mb-3">
        <label for="characterNationality" class="form-label">Nationality:</label>
        <input type="text" class="form-control" name="characterNationality" id="characterNationality" 
               value="<?php echo htmlspecialchars($character['nacionalidad_persona'] ?? ''); ?>"
               <?php echo ($formAction === 'addCharacter' || $formAction === 'editCharacter') ? '' : 'readonly'; ?>>
    </div>

    <div class="mb-3">
        <label for="characterGender" class="form-label">Gender:</label>
        <select class="form-select" name="characterGender" id="characterGender" <?php echo ($formAction !== 'addCharacter' && $formAction !== 'editCharacter') ? 'disabled' : ''; ?>>
            <option value="M" <?php echo (strtoupper($character["sexo_persona"] ?? '') === "M") ? "selected" : ""; ?>>Male</option>
            <option value="F" <?php echo (strtoupper($character["sexo_persona"] ?? '') === "F") ? "selected" : ""; ?>>Female</option>
            <option value="O" <?php echo (strtoupper($character["sexo_persona"] ?? '') === "O") ? "selected" : ""; ?>>Other</option>
        </select>
    </div>

    <div class="mt-3">
        <?php showFormButton($formAction,$character); ?> <!-- Display the appropriate form button based on action -->
    </div>
</form>

<?php 
if (!empty($errors)) {
    showErrors($errors); // Display any errors if present.
} else if ($showMessage) {
    showDoneMessage($formAction); // Display a success message if the action was successful.
}

require("./../components/footer.php");
?>

