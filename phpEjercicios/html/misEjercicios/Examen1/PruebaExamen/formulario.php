<?php 
require_once("funciones.php");
require_once("./database.php")

?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <?php valoraAccion()?>
    <?php 
    if($_SERVER['REQUEST_METHOD']==="POST"){
        if($_POST["opcion"]=="eliminado"){
            eliminaCliente($_SESSION["data"],$_GET["id"]);
            echo "<script>window.location.replace(\"./index.php\");</script>";
        }
        else if($_POST["opcion"]=="editado"){
            editaCliente($_SESSION["data"],$_GET["id"],$_POST["id"],$_POST["name"],$_POST["surname"],$_POST["gender"],$_POST["address"]);
            echo "<script>window.location.replace(\"./index.php\");</script>";
        }
        
    }
    
    
    ?>
    <form method="POST">
    <div class="mb-3">
        <label for="Id" class="form-label">ID</label>
        <input type="number" class="form-control" id="Id" value="<?php echo encuentraCliente($_SESSION["data"],$_GET["id"])["id"]?>" <?php disabledOrNot() ?>>
    </div>
    <div class="mb-3">
        <label for="Nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="Nombre" value="<?php echo encuentraCliente($_SESSION["data"],$_GET["id"])["name"]?>" <?php disabledOrNot() ?>>
    </div>
    <div class="mb-3">
        <label for="Apellido" class="form-label">Apellido</label>
        <input type="text" class="form-control" id="Apellido" value="<?php echo encuentraCliente($_SESSION["data"],$_GET["id"])["surname"]?>" <?php disabledOrNot() ?>>
    </div>
    <div class="mb-3">
        <label for="Genero" class="form-label">Genero</label>
        <input type="text" class="form-control" id="Genero" value="<?php echo encuentraCliente($_SESSION["data"],$_GET["id"])["gender"]?>"<?php disabledOrNot() ?>>
    </div>
    <div class="mb-3">
        <label for="Direccion" class="form-label">Direccion</label>
        <input type="text" class="form-control" id="Direccion"value="<?php echo encuentraCliente($_SESSION["data"],$_GET["id"])["address"]?>"  <?php disabledOrNot() ?>>
    </div>
    <?php botones()?>
    </form>
</body>
</html>
