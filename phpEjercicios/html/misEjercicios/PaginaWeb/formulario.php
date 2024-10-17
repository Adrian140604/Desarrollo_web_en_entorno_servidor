<?php
session_start();
require_once("clientes.php");
require_once("eliminarCliente.php");
require_once("utility.php");
$cliente=findCliente($_SESSION['data'], $_GET['id']);
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
    <?php valoraAccion($_GET['accion'])?>
        <form action="" method="post">
            <div class="form-group">
                <label for="id">ID</label>
                <input type="text" class="form-control" id="id" value=<?php echo $cliente['id'];?> <?php disableOrnot($_GET["accion"])?>>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" value=<?php echo $cliente['name'];?> <?php disableOrnot($_GET["accion"])?>>
            </div>
            <div class="form-group">
                <label for="apellidos">Apellidos</label>
                <input type="text" class="form-control" id="apellidos" value=<?php echo $cliente['surname'];?> <?php disableOrnot($_GET["accion"])?>>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" value=<?php echo $cliente['email'];?> <?php disableOrnot($_GET["accion"])?>>
            </div>
            <div class="form-group">
                <label for="genero">Género</label>
                <select class="form-control" id="genero" <?php disableOrnot($_GET["accion"])?>>
                    <option value=""><?php echo $cliente['gender'];?></option>
                    <option value="masculino">Masculino</option>
                    <option value="femenino">Femenino</option>
                    <option value="otro">Otro</option>
                </select>
            </div>
            <div class="form-group">
                <label for="contraseña">Direccion</label>
                <input type="text" class="form-control" id="direccion" value=<?php echo $cliente['address'];?> <?php disableOrnot($_GET["accion"])?>>
  
          </div>
          <div class="container my-4">
            <?php
                valoraAccion($cliente);
                if($_GET["accion"]=="eliminar"){
                    echo " <button type=\"submit\" class=\"btn btn-primary\">Eliminar</button>";
                    eliminaCliente($cliente['id'],$_SESSION['data']);
                          
                }
                else if ($_GET["accion"]== "verMas"){
                    echo "<button type=\"submit\" class=\"btn btn-primary\">Volver atras</button>";
                }
                else{
                    echo "<button type=\"submit\" class=\"btn btn-primary\">Guardar Cambios</button>";
                }
            ?>
    </div>
        </form>
    

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
