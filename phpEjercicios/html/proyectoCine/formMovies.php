<?php
session_start(); // Start the session to use session variables
require("./components/header.php"); // Import header component
require_once("./functions/movieFunctions.php"); // Import movie-related functions
require_once("./functions/Database.php"); // Import database connection functions

// Establish connection with the database
$connection = Database::getInstance()->getConnection();

// Default movie data structure to store movie information
$movie = [
    "cip" => "",
    "titulo_p" => "",
    "ano_produccion" => "",
    "titulo_s" => "",
    "nacionalidad" => "",
    "presupuesto" => "",
    "duracion" => ""
];

$deleted = false; // Flag to check if a movie was deleted
$added = false; // Flag to check if a movie was added
$edited = false; // Flag to check if a movie was edited

// Validate action
$action = $_GET["accion"] ?? '';

if (!in_array($action, ['add', 'editar', 'eliminar','vermas'])) {
    $errorMsg = "Error: La accion no existe.";
    echo "<script>window.location.replace('error.php?msg=" . urlencode($errorMsg) . "');</script>";
    exit; // Terminate script execution
}

// Check if there's a "cip" parameter in the URL, if true, load movie data
if (!empty($_GET["cip"]) || $movie["cip"] != "") {
    $movie = getMovie($connection, $_GET["cip"]);
    
    // Check if the movie was found
    if (!$movie) {
        // Show an error message if the movie does not exist
        $errorMsg = "Error: La pelicula no existe.";
        echo "<script>window.location.replace('error.php?msg=" . urlencode($errorMsg) . "');</script>";
        exit; // Terminate script execution
    }
}

// Handle form submission when it's a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle action based on the action variable
    if ($action === "add") {
        // Check if all required fields are complete
        if (empty($_POST["name"]) || empty($_POST["age"]) || empty($_POST["id"]) || 
            empty($_POST["secondary-title"]) || empty($_POST["nationality"]) || 
            empty($_POST["budget"]) || empty($_POST["duration"])) {
            // Show an error message if any field is missing
            $errorMsg = "Error: Debes rellenar todos los cambios.";
            echo "<script>window.location.replace('error.php?msg=" . urlencode($errorMsg) . "');</script>";
        }
    
        // Check if the movie title and production year already exist in the database
        if (repeatMovie($_POST["name"], $_POST["age"], $connection)) {
            // Show an error message if the movie already exists
            $errorMsg = "Error: Ya existe una peliucla con el mismo nombre o año.";
            echo "<script>window.location.replace('error.php?msg=" . urlencode($errorMsg) . "');</script>";
        }
    
        // Check if the ID already exists
        if (checkDuplicateId($_POST["id"], $connection)) {
            // Show an error message if the ID already exists
            $errorMsg = "Error: Ya existe una pelicula con el mismo id";
            echo "<script>window.location.replace('error.php?msg=" . urlencode($errorMsg) . "');</script>";
        }
    
        // Validate the production year; if incorrect, return without adding the movie
        if (ageproduction($_POST["age"])) {
            return;
        }
    
        // Add new movie data to the database
        addMovie($_POST["id"], $_POST["name"], $_POST["age"], $_POST["secondary-title"], $_POST["nationality"], $_POST["budget"], $_POST["duration"], $connection);
        
        // Store a success message in the session
        $_SESSION['success_message'] = "Movie created successfully.";
        echo "<script>window.location.replace('formMovies.php?accion=vermas&cip={$_POST["id"]}');</script>";
    }
    elseif ($action === "editar") {
        // Get the current movie data
        $currentTitle = $movie["titulo_p"];
        $currentYear = $movie["ano_produccion"];
    
        // Check if the title or production year has changed
        if ($_POST["name"] != $currentTitle || $_POST["age"] != $currentYear) {
            // Check if the movie title and production year already exist in the database
            if (repeatMovie($_POST["name"], $_POST["age"], $connection)) {
                // Show an error message if the movie already exists
                $errorMsg = "Error: Ya existe una peliucla con el mismo nombre o año";
                echo "<script>window.location.replace('error.php?msg=" . urlencode($errorMsg) . "');</script>";
                exit; // Ensure to exit after redirecting
            }
    
            // Validate the production year; if incorrect, return without editing the movie
            if (ageproduction($_POST["age"])) {
                return; // Exit if there's an error in the production year
            }
        }
    
        // Update movie data in the database
        editMovie(
            $movie["cip"],
            $_POST["name"],
            $_POST["age"],
            $_POST["secondary-title"],
            $_POST["nationality"],
            $_POST["budget"],
            $_POST["duration"],
            $connection
        );
    
        // Indicate that the movie has been edited
        $edited = true;
    
        // Redirect to the movie list after editing
        echo "<script>window.location.replace('showMoviesList.php');</script>"; // Redirect to the movie list
        exit; // Terminate the script execution
    }
    
    elseif ($action === "eliminar") {
        // Handle movie deletion if delete button is clicked
        deleteMovie($movie["cip"], $connection);
        $deleted = true;
    } else {
        // If action is not recognized at this point, redirect to an error page
        $errorMsg = "Error: La accion no existe.";
        echo "<script>window.location.replace('error.php?msg=" . urlencode($errorMsg) . "');</script>";
        exit; // Terminate script execution
    }
}

// Display the title based on the action type
echo "<h2>" . viewTitle($action) . "</h2>";
?>

<form class="container mt-4" method="POST">
    <div class="row mb-2">
        <div class="col-md-6">
            <label for="id" class="form-label">ID:</label>
            <input type="text" class="form-control" id="id" name="id" value="<?php echo htmlspecialchars($movie["cip"]); ?>" <?php if ($movie["cip"] != "") { viewdisabledprimarykey($action); } ?>>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-6">
            <label for="name" class="form-label">Title:</label>
            <input type="text" class="form-control" id="name" name="name" required value="<?php echo htmlspecialchars($movie["titulo_p"]); ?>" <?php if ($movie["cip"] != "") { viewDisabled($action); } ?>>
        </div>
        <div class="col-md-6">
            <label for="age" class="form-label">Production Year:</label>
            <input type="text" class="form-control" id="age" name="age" required value="<?php echo htmlspecialchars($movie["ano_produccion"]); ?>" <?php if ($movie["cip"] != "") { viewDisabled($action); } ?>>
        </div>
    </div>
  
    <div class="row mb-2">
        <div class="col-md-6">
            <label for="secondary-title" class="form-label">Secondary Title:</label>
            <input type="text" class="form-control" id="secondary-title" name="secondary-title" value="<?php echo htmlspecialchars($movie["titulo_s"]); ?>" <?php if ($movie["cip"] != "") { viewDisabled($action); } ?>>
        </div>
        <div class="col-md-6">
            <label for="nationality" class="form-label">Nationality:</label>
            <input type="text" class="form-control" id="nationality" name="nationality" value="<?php echo htmlspecialchars($movie["nacionalidad"]); ?>" <?php if ($movie["cip"] != "") { viewDisabled($action); } ?>>
        </div>
    </div>
  
    <div class="row mb-2">
        <div class="col-md-6">
            <label for="budget" class="form-label">Budget:</label>
            <input type="text" class="form-control" id="budget" name="budget" value="<?php echo htmlspecialchars($movie["presupuesto"]); ?>" <?php if ($movie["cip"] != "") { viewDisabled($action); } ?>>
        </div>
        <div class="col-md-6">
            <label for="duration" class="form-label">Duration:</label>
            <input type="text" class="form-control" id="duration" name="duration" value="<?php echo htmlspecialchars($movie["duracion"]); ?>" <?php if ($movie["cip"] != "") { viewDisabled($action); } ?>>
        </div>
    </div>

    <?php if ($deleted) { ?>
        <div class="alert alert-success" role="alert">Movie deleted successfully.</div>
    <?php } ?>

    <?php if ($edited) { ?>
        <div class="alert alert-success" role="alert">Movie edited successfully.</div>
    <?php } ?>

    <div class="row mt-3">
        <?php 
        // Show the success message if it exists
        if (isset($_SESSION['success_message'])) {
            echo "<div class='alert alert-success' role='alert'>" . $_SESSION['success_message'] . "</div>";
            unset($_SESSION['success_message']); // Clear the message after displaying it
        }
        // Check the action type and display the appropriate button
        if (isset($action)) {
            if ($deleted || $edited || $added) {
                echo "<div class=\"col text-center\"><a href=\"showMoviesList.php\" class=\"btn btn-primary\">Back</a></div>";
            } else {
                viewButton($action);
            }
        }
        ?>
    </div>
</form>

<?php require "./components/footer.php"; ?>
