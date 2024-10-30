<?php //Datos requeridos
    require_once("./database.php");
    require_once("./cabecera.php");
    
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
        <h1>Cliente</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Genero</th>
                    <th>Direccion</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php  //Esta parte va a crear la tabla, lo que hace es recorrer todos los clientes de la base de datos e ir poniendo los atributos de cada cliente uno a uno
                    foreach ($_SESSION["data"] as $cliente) {
                        echo '<tr>';
                        echo "<td>$cliente[id]</td>";
                        echo "<td>$cliente[name]</td>";
                        echo "<td>$cliente[surname]</td>";
                        echo "<td>$cliente[email]</td>";
                        echo "<td>$cliente[gender]</td>";
                        echo "<td>$cliente[address]</td>";
                        echo "<td>".
                            "<a href='./formulario.php?action=verMas&id=$cliente[id]' class='btn btn-info'>Ver más</a> ". //Tenemos que añadir a parte de la direccion donde queremos que nos redirija , la accion que vamos a hacer y el id
                            "<a href='./formulario.php?action=editar&id=$cliente[id]' class='btn btn-warning'>Editar</a> ".
                            "<a href='./formulario.php?action=eliminar&id=$cliente[id] ' class='btn btn-danger'>Eliminar</a>".
                        "</td>";
                        echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
    
</body>
</html>