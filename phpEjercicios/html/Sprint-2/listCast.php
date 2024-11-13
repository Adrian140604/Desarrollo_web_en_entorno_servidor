<?php //Datos requeridos
  require("./components/header.php");
  require("./functions/Database.php");
  $connection = Database::getInstance()->getConnection();
  require("./functions/movieFunctions.php");
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
</head>
<body>

<div class="container mt-4">
        <h1>Filmografia</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Actor</th>
                    <th>Rol</th>
                </tr>
            </thead>
            <tbody>
                <?php  //Esta parte va a crear la tabla, lo que hace es recorrer todos los clientes de la base de datos e ir poniendo los atributos de cada cliente uno a uno
                    showCast($connection);
                ?>
            </tbody>
        </table>
    </div>
    
</body>
</html>