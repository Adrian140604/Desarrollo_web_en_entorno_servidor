
<?php
// Es la página del formulario, su contenido irá cambiando según el valor de $_GET["form-action"]
require("../components/header.php"); // Add the header to this page.
require_once("../functions/screeningFunctions.php"); // Import cinemaFunctions.php (this file have all the functions of cinemas)
require_once("../functions/Database.php"); // Import Database connection.
$connection = Database::getInstance()->getConnection(); // Start connection.

$action = validateScreening($_GET["screeningAction"]);

if ($action != "addScreening") {
    $screening = findScreening($connection, $_GET["cine"],$_GET["sala"], $_GET["fecha_estreno"], $_GET["cip"]);
} else {
    $screening = ["cine" => "", "sala" => "", "cip" => "", "fecha_estreno" => "", "dias_estreno" => "", "espectadores"=>"", "recaudacion"=>""];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    switch ($action) {
      case "editScreening" :
        $aforo = getAforo($screening['cine'], $screening['cip'], $screening['sala'], $screening['fecha_estreno'], $connection);

        var_dump($screening['sala']);
        var_dump($aforo);
        var_dump($screening['cine']);
        if (editScreening($connection, $screening['cine'], $screening['sala'], $screening['cip'], $screening['fecha_estreno'], $aforo)) {
          $action = "screeningUpdated";
          $screening = findScreening($connection, $_POST["cinema"],$_POST["room"], $_POST["release-date"], $_POST["cip"]);
          $showMessage = true;
        } else {
          $screening = ["cine" => $screening["cine"], "sala" => $_POST["room"], "cip" => $_POST["cip"], "fecha_estreno" => $_POST["release-date"], "dias_estreno" => $_POST["release-days"], "espectadores"=>$_POST["spectators"], "recaudacion"=> $_POST["collection"] ];
          //$errors = validateInputData($cinema["cine"], $_POST["age"], $_POST["city"], $_POST["address"], $connection, $action);
        }
        break;
      case "addScreening" :
        if (addScreening($connection)) {
          $action = "screeningAdded";
          $screening = findScreening($connection, $_POST["cine"],$_POST["sala"], $_POST["release-date"], $_POST["cip"]);
          $showMessage = true;
        } else {
          $screening = ["cine" => $screening["cine"], "sala" => $_POST["sala"], "cip" => $_POST["cip"], "fecha_estreno" => $_POST["release-date"], "dias_estreno" => $_POST["release-days"], "espectadores"=>$_POST["spectators"], "recaudacion"=> $_POST["collection"] ];
          //$errors = validateInputData($_POST["name"], $_POST["age"], $_POST["city"], $_POST["address"], $connection, $action);
        }
        break;
      case "deleteScreening" : 
        deleteScreening($connection, $screening["cine"], $screening["sala"], $screening["fecha_estreno"], $screening["cip"] );
        $action = "screeningDeleted";
        $showMessage = true;
    }
}

?>

<form class="container mt-4" method="POST">  
  <?php showFormTitle($action); ?>
  
  <!-- Selección de Cine -->
  <div class="row mb-3">
    <div class="col-md-3 offset-md-3">
        <label for="cine" class="form-label">Cine: <span class="text-danger">*</span></label>
        <select required class="form-control" id="cine" name="cine" <?php echo disabledOrNotPrimaryKey($action); ?>>
            <option value="">Selecciona un cine</option>
            <?php 
                foreach (getCinemas($connection) as $cine) {
                    $selected = ($cine['cine'] === $screening["cine"]) ? 'selected' : '';
                    echo "<option value='{$cine['cine']}' $selected>{$cine['cine']}</option>";
                }
            ?>
        </select>

    </div>
    <!-- Selección de Sala -->
    <div class="col-md-3">
        <label for="sala" class="form-label">Sala: <span class="text-danger">*</span></label>
        <select required class="form-control" id="sala" name="sala" <?php echo disabledOrNotPrimaryKey($action); ?>>
          <option value="">Selecciona una sala</option>
          <?php 
              foreach (getRooms($connection) as $room) {
                  $selected = ($room['sala'] === $screening["sala"]) ? 'selected' : '';
                  echo "<option value='{$room['sala']}' $selected>{$room['sala']}</option>";
              }
          ?>
      </select>

    </div>
  </div>

  <!-- Selección de Película -->
  <div class="row mb-3">
    <div class="col-md-3 offset-md-3">
        <label for="cip" class="form-label">Película (CIP): <span class="text-danger">*</span></label>
        <select required class="form-control" id="cip" name="cip" <?php echo disabledOrNotPrimaryKey($action); ?>>
          <option value="">Selecciona una película</option>
          <?php 
              foreach (getMovies($connection) as $movie) {
                  $selected = ($movie['cip'] === $screening["cip"]) ? 'selected' : '';
                  echo "<option value='{$movie['cip']}' $selected>{$movie['cip']}</option>";
              }
          ?>
      </select>

    </div>
    <div class="col-md-3">
        <label for="release-date" class="form-label">Fecha de estreno:</label>
        <input type="date" class="form-control" id="release-date" name="release-date" value="<?php echo $screening["fecha_estreno"]; ?>" <?php echo disabledOrNotPrimaryKey($action); ?>>
        </div>
  </div>
  <div class="row mb-3">
    <div class="col-md-3 offset-md-3">
        <label for="release-days" class="form-label">Días de estreno: <span class="text-danger">*</span></label>
        <input type="number" required class="form-control" id="release-days" name="release-days" value="<?php print "{$screening["dias_estreno"]}"; ?>" <?php disabledOrNot($action);?>>
    </div>
    <div class="col-md-3">
        <label for="spectators" class="form-label">Espectadores:</label>
        <input type="number" class="form-control" id="spectators" name="spectators" value="<?php print "{$screening["espectadores"]}"; ?>" <?php disabledOrNot($action);?>>
    </div>
    <div class="row mb-3">
      <div class="col-md-3 offset-md-3">
        <label for="collection" class="form-label">Recaudación: <span class="text-danger">*</span></label>
        <input type="number" required class="form-control" id="collection" name="collection" value="<?php print "{$screening["recaudacion"]}"; ?>" <?php disabledOrNot($action);?>>
      </div>
    </div>
  </div>

  <?php 

if($action == "editScreening"){
  $aforo = getAforo($screening['cine'], $screening['cip'], $screening['sala'], $screening['fecha_estreno'], $connection);

  print "
  <div class='row mb-3'>
    <div class='col-md-3 offset-md-3'>
      <label for='aforo' class='form-label'>Aforo; <span class='text-danger'>*</span></label>
      <input type='number' required class='form-control' id='aforo' name='aforo' value='{$aforo}'<?php disabledOrNot($action);?>
    </div>
  </div>
</div>
";
}

?>
  
  <!-- Botón para enviar -->
  <?php showFormButton($action, $screening); ?>
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