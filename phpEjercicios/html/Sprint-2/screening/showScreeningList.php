<?php
    // THIS PAGE SHOW THE LIST OF ALL CINEMAS
    require_once "../functions/Database.php"; // Import Database connection.
    $connection = Database::getInstance()->getConnection(); // Start connection.
    require("../components/header.php"); // Add the header to this page.
    require_once("../functions/screeningFunctions.php"); // Import cinemaFunctions.php (this file have all the functions of cinemas)
   
?>

<div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2 class="my-4">Lista de proyecciones</h2>
      </div>
      <div class="col-md-6 text-end">
        <a href="./formScreenings.php?screeningAction=addScreening" class="btn btn-success flex-column my-4">Añadir proyección</a>
      </div>
    </div>
    
    <table class="table table-striped table-hover">
  <thead>
    <tr>
      <th scope="col">Cine</th>
      <th scope="col">Sala</th>
      <th scope="col">CIP</th>
      <th scope="col">Fecha de estreno</th>
      <th scope="col" class="text-end">Acción</th>
    </tr>
  </thead>
    <?php
      listScreenings($connection);
    ?>
  </table>
</div>

  <?php
    require("../components/footer.php")
  ?>
  <tbody>
