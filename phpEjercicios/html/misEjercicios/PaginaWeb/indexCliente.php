<?php session_start()?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../PaginaWeb/index.css">
    <link rel="stylesheet" href="../PaginaWeb/indexCliente.css">
</head>
<body>
    <?php include 'cabecera.php'; // Importamos la cabecera ?>
    <?php include 'clientes.php'; // Importamos el $data que está en clientes.php ?>
    
    <main class="container my-4">
        <h2 class="text-center mb-4">Lista de Usuarios</h2>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($_SESSION['data'] as $dni => $cliente) { // Esto recorre data que es lo que hemos importado
                    echo "<tr>";
                    echo "<td>{$cliente['id']}</td>"; // Las llaves son para decirle que va a ir una variable
                    echo "<td>{$cliente['name']}</td>";
                    echo "<td>{$cliente['surname']}</td>";
                    echo "<td>
                            <a href=\"formulario.php?accion=editar&id={$cliente['id']}\" class=\"btn btn-primary btn-sm\">Editar</a>
                            <a href=\"formulario.php?accion=eliminar&id={$cliente['id']}\" class=\"btn btn-danger btn-sm\">Eliminar</a>
                            <a href=\"formulario.php?accion=verMas&id={$cliente['id']}\" class=\"btn btn-info btn-sm\">Ver Más</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </main>

    <?php include 'pie.php'; ?>
    
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
