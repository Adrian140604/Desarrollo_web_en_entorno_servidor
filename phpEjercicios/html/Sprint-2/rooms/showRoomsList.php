<?php
    // THIS PAGE SHOW THE LIST OF ALL ROOMS
    require("../components/header.php"); // Add the header to this page.
    require_once("../functions/roomsFunctions.php"); // Import cinemaFunctions.php (this file have all the functions of cinemas)
    require_once "../functions/Database.php"; // Import Database connection.
    $connection = Database::getInstance()->getConnection(); // Start connection.
    
    
?>


<div class="container">
    <div class="row">
    <div class="col-md-6">
    <h2 class="text-center my-4">Lista de Salas</h2>
    </div>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Sala</th>
                <th scope="col" class="text-end">Aforo</th>
            </tr>
        </thead>
        <tbody>
            <?php
                listhall($connection); // Llama a la función para listar salas


            ?>

        </tbody>
    </table>
</div>


  <?php
    require("../components/footer.php")
  ?>
  <tbody>
