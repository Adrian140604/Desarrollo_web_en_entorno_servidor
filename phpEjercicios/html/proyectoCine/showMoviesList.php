<?php
    // THIS PAGE SHOW THE LIST OF ALL CINEMAS
    require("./components/header.php"); // Add the header to this page.
    require_once("./functions/movieFunctions.php"); // Import cinemaFunctions.php (this file have all the functions of cinemas)
    require_once("./functions/Database.php");
    $connection = Database::getInstance()->getConnection(); // Start connection.
?>


<div class="container">
    <div class="row">
    <div class="col-md-6">
    <h2 class="text-center my-4">Lista de Peliculas</h2>
	</div>
    <div class="col-md-6 text-end">
            <a href="./formMovies.php?accion=add" class="btn btn-success my-5">Añadir Personaje</a>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col" class="text-end">Acción</th> <!-- Columna "Acción" alineada a la derecha -->
            </tr>
        </thead>
        <tbody>
            <?php
                listmovie($connection); // Llama a la función para listar las películas
            ?>
        </tbody>
    </table>
</div>

  <?php
    require("./components/footer.php")
  ?>
  <tbody></tbody>
