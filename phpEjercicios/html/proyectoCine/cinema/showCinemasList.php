<?php
    // THIS PAGE SHOW THE LIST OF ALL CINEMAS
    require("../components/header.php"); // Add the header to this page.
    require_once("../functions/cinemaFunctions.php"); // Import cinemaFunctions.php (this file have all the functions of cinemas)
    require_once "../functions/Database.php"; // Import Database connection.
    $connection = Database::getInstance()->getConnection(); // Start connection.
?>

<div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2 class="my-4">Lista de cines</h2>
      </div>
      <div class="col-md-6 text-end">
        <a href="./formCinemas.php?cinemaAction=addCinema" class="btn btn-success flex-column my-4">Añadir Cine</a>
      </div>
    </div>
    
    <table class="table table-striped table-hover">
  <thead>
    <tr>
      <th scope="col">Nombre</th>
      <th scope="col">Ciudad</th>
      <th scope="col" class="text-end">Acción</th>
    </tr>
  </thead>
    <?php
      listCinemas($connection);
    ?>
  </table>
</div>

  <?php
    require("../components/footer.php")
  ?>
  <tbody>
