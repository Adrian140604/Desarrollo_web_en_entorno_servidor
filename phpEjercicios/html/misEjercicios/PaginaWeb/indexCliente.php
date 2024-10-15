<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link rel="stylesheet" href="../PaginaWeb/index.css">
    <link rel="stylesheet" href="../PaginaWeb/indexCliente.css">
</head>
<body>
    <?php include 'cabecera.php'; //Importamos la cabecera
    ?> 
    <?php include 'clientes.php';//Importamos el $data que esta en clientes.php
    ?>
    <main class="container my-4">
<main class="flex-grow-1 container my-4">
    <h2>Lista de Usuarios</h2>
    <table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach($data as $dni=>$cliente){ //Esto recorre data que es lo que hemos importado, dentro hay codigo html y mas explicaciones
            echo "<tr>";
            echo "<td>{$cliente['id']}<td/>"; //Las llaves son para decirle que va a ir una variable, despues dentro de el corchete le indicamos a que atributo queremos acceder
            echo "<td>{$cliente['name']} <td/>";
            echo "<td>{$cliente['surname']} <td/>";
            echo "<td><a href=\"formulario.php?accion=editar&id={$cliente['id']}\" class=\"btn btn-danger btn-sm\">Eliminar</a>
                <a href=\"formulario.php?accion=eliminar&id={$cliente['id']}\" class=\"btn btn-warning btn-sm\">Modificar</a> 
                <a href=\"formulario.php?accion=verMas&id={$cliente['id']}\" class=\"btn btn-warning btn-sm\">Ver Mas</a>

                <td/>";
            
        }


        ?>
    </tbody>
    </table>
    </main>

</main>
    
    <?php include 'pie.php'; ?>    
</body>
</html>