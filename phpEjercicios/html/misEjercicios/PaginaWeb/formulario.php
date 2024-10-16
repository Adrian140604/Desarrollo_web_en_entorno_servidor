<?php
include("clientes.php");
$id = 0;
$nombre = "";
$apellidos = "";
$email = "";
$genero = "";
$contrasenia = "";


if (isset($_GET["id"])) {
    foreach ($data as $cliente) { 
        if ($_GET["id"] == $cliente['id']) {
            $id = $cliente['id'];
            $nombre = $cliente['name'];
            $apellidos = $cliente['surname'];
            $email = $cliente['email'];
            $genero = $cliente['gender'];
            $contrasenia = $cliente['address']; 
            break; 
        }
    }
}

function valoraAccion($id,$nombre,$apellidos,$email,$genero,$contrasenia){ //Recordar que no puede haber codigo html dentro de php, es decir con un echo sio que se puede pero al tener funciones php dentro podemos hacerlo asi 
    switch($_GET["accion"]){
        case "eliminar":
            echo "<h2 class=\"text-center mb-4\">Borrando Cliente</h2>";
            break;
        case "verMas":
            echo "<h2 class=\"text-center mb-4\">Mostrando Cliente</h2>";
            break;
        case "editar":
            echo "<h2 class=\"text-center mb-4\">Editando Cliente</h2>";
            break;

    }
    if($_GET["accion"]=="eliminar"||$_GET["accion"]=="verMas"){?>
        <div class="form-group">
                <label for="id">ID</label>
                <input type="text" class="form-control" id="id" placeholder=<?php echo $id;?> disabled>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" placeholder=<?php echo $nombre;?> disabled>
            </div>
            <div class="form-group">
                <label for="apellidos">Apellidos</label>
                <input type="text" class="form-control" id="apellidos" placeholder=<?php echo $apellidos;?> disabled>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" placeholder=<?php echo $email;?> disabled>
            </div>
            <div class="form-group">
                <label for="genero">Género</label>
                <select class="form-control" id="genero" disabled>
                    <option value=""><?php echo $genero;?></option>
                    <option value="masculino">Masculino</option>
                    <option value="femenino">Femenino</option>
                    <option value="otro">Otro</option>
                </select>
            </div>
            <div class="form-group">
                <label for="contraseña">Contraseña</label>
                <input type="password" class="form-control" id="contraseña" placeholder=<?php echo $contrasenia;?> disabled>
  
          </div>
<?php   }
    else{?>
            <div class="form-group">
                <label for="id">ID</label>
                <input type="text" class="form-control" id="id" value=<?php echo $id;?> >
            </div>
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" value=<?php echo $nombre;?> >
            </div>
            <div class="form-group">
                <label for="apellidos">Apellidos</label>
                <input type="text" class="form-control" id="apellidos" value=<?php echo $apellidos;?> >
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" value=<?php echo $email;?> >
            </div>
            <div class="form-group">
                <label for="genero">Género</label>
                <select class="form-control" id="genero" >
                    <option value=""><?php echo $genero;?></option>
                    <option value="masculino">Masculino</option>
                    <option value="femenino">Femenino</option>
                    <option value="otro">Otro</option>
                </select>
            </div>
            <div class="form-group">
                <label for="contraseña">Contraseña</label>
                <input type="password" class="form-control" id="contraseña" placeholder=<?php echo $contrasenia;?> >
            </div>
<?php   }
    

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-4">
        <form action="indexCliente.php" method="post">
            <?php
                valoraAccion($id,$nombre,$apellidos,$email,$genero,$contrasenia);
                if($_GET["accion"]=="eliminar"){
                    echo " <button type=\"submit\" class=\"btn btn-primary\">Eliminar</button>
                           <button type=\"submit\" class=\"btn btn-primary\">Volver atras</button>";
                }
                else if ($_GET["accion"]== "verMas"){
                    echo "<button type=\"submit\" class=\"btn btn-primary\">Volver atras</button>";
                }
                else{
                    echo "<button type=\"submit\" class=\"btn btn-primary\">Guardar Cambios</button>";
                }
            ?>

        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
