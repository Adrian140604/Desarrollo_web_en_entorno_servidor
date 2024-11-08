<?php
// Es la página del formulario, su contenido irá cambiando según el valor de $_GET["form-action"]
require("../components/header.php"); // Add the header to this page.
require_once("../functions/cinemaFunctions.php"); // Import cinemaFunctions.php (this file have all the functions of cinemas)
require_once("../functions/Database.php"); // Import Database connection.
$connection = Database::getInstance()->getConnection(); // Start connection.

$action = validateCinemaAction($_GET["cinemaAction"]);

if ($action != "addCinema") {
    $cinema = getCinema($_GET["cinema"], $connection);
} else {
    $cinema = ["cine" => "", "antiguedad" => "", "ciudad_cine" => "", "direccion_cine" => ""];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    switch ($action) {
      case "editCinema" :
        if (editCinema($cinema["cine"], $_POST["age"], $_POST["city"], $_POST["address"], $connection)) {
          $action = "cinemaUpdated";
          $cinema = getCinema($cinema["cine"], $connection);
          $showMessage = true;
        } else {
          $cinema = ["cine" => $cinema["cine"], "antiguedad" => $_POST["age"], "ciudad_cine" => $_POST["city"], "direccion_cine" => $_POST["address"]];
          $errors = validateInputData($cinema["cine"], $_POST["age"], $_POST["city"], $_POST["address"], $connection, $action);
        }
        break;
      case "addCinema" :
        if (addCinema($_POST["name"], $_POST["age"], $_POST["city"], $_POST["address"], $connection)) {
          $action = "cinemaAdded";
          $cinema = getCinema($_POST["name"], $connection);
          $showMessage = true;
        } else {
          $cinema = ["cine" => $_POST["name"], "antiguedad" => $_POST["age"], "ciudad_cine" => $_POST["city"], "direccion_cine" => $_POST["address"]];
          $errors = validateInputData($_POST["name"], $_POST["age"], $_POST["city"], $_POST["address"], $connection, $action);
        }
        break;
      case "deleteCinema" : 
        deleteCinema($cinema["cine"], $connection);
        $action = "cinemaDeleted";
        $showMessage = true;
    }
}

?>

<form class="container mt-4" method="POST">  
  <?php showFormTitle($action) ?>
  <div class="row mb-3">
    <div class="col-md-3 offset-md-3">
        <label for="name" class="form-label">Nombre: <span class="text-danger">*</span></label>
        <input type="text" required class="form-control" id="name" name="name" value="<?php print "{$cinema["cine"]}"; ?>" <?php disabledOrNotPrimaryKey($action);?>>
    </div>
    <div class="col-md-3">
        <label for="age" class="form-label">Antigüedad:</label>
        <input type="number" min="1" step="0" class="form-control" id="age" name="age" value="<?php print "{$cinema["antiguedad"]}"; ?>" <?php disabledOrNot($action);?>>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-md-3 offset-md-3">
        <label for="city" class="form-label">Ciudad: <span class="text-danger">*</span></label>
        <input type="text" required class="form-control" id="city" name="city" value="<?php print "{$cinema["ciudad_cine"]}"; ?>" <?php disabledOrNot($action);?>>
    </div>
    <div class="col-md-3">
        <label for="address" class="form-label">Dirección:</label>
        <input type="text" class="form-control" id="address" name="address" aria-describedby="emailHelp" value="<?php print "{$cinema["direccion_cine"]}"; ?>" <?php disabledOrNot($action);?>>
    </div>
  </div>
  <?php showFormButton($action, $cinema); ?>
</form>

<?php
  if (isset($errors)) {
    showErrors($errors);
  }
  if (isset($showMessage)) {
    showDoneMessage($action);
  }
require "../components/footer.php"; // Add the footer to this page.
?>
