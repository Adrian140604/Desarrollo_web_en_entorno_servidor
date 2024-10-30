<?php require '../database_cine.php';

    $conexion = Database::getInstance()->getConnection();

    $query = "SELECT * FROM Tarea";
    $call = $conexion->query($query);
    $listaTarea = $call->fetchAll(PDO::FETCH_ASSOC); //Esto devuelve todas las filas de una vez

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tareas</title>
    <!-- Enlace a Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../cabecera_footer.css">

</head>
<body>
    <?php require_once("../cabecera.html")?>
    <div class="container mt-4">
        <h1>Tareas</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Tarea</th>
                    <th>Sexo Tarea</th>
                    <th>Salario Base</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ($listaTarea as $tarea) {
                        echo '<tr>';
                        echo "<td>$tarea[tarea]</td>";
                        echo "<td>$tarea[sexo_tarea]</td>";
                        echo "<td>$tarea[salario_base]</td>";
                        echo "<td>".
                            "<a href='./formularioTarea.php?action=verMas&id=$tarea[tarea]' class='btn btn-info'>Ver más</a> ".
                            "<a href='./formularioTarea.php?action=aniadir&id=$tarea[tarea]' class='btn btn-primary'>Añadir</a> ".
                            "<a href='./formularioTarea.php?action=editar&id=$tarea[tarea]' class='btn btn-warning'>Editar</a> ".
                            "<a href='./formularioTarea.php?action=eliminar&id=$tarea[tarea]' class='btn btn-danger'>Eliminar</a>".
                        "</td>";
                        echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
    <?php require_once("../footer.html")?>
    <!-- Enlace a Bootstrap JS (opcional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
