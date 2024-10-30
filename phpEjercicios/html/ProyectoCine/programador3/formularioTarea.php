<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../cabecera_footer.css">
</head>
<body>
    
    <?php 
     include "../cabecera.html";
     require_once("./disableOrNot.php");   
     require_once("./funcionesTarea.php"); 
     require_once("./ProyectoCine/database_cine.php");
     $conexion = Database::getInstance()->getConnection();
     $tareaBuscar=getTarea($_GET["id"],$conexion);

    ?>
    <div class="container d-flex justify-content-center align-items-center h-100">
        <div class="card shadow-lg p-4 w-100" style="max-width: 600px;">
            <h2 class="text-center mb-4"><?php valoraAccion()?></h2>
            
            <form action="procesar_tarea.php" method="POST">
                <div class="mb-3">
                    <label for="Actor Principal" class="form-label">Tarea</label>
                    <input type="text" class="form-control" id="Tarea" name="Tarea" value="<?php echo htmlspecialchars($tareaBuscar['tarea']) ?>" <?php disableOactive()?>>
                </div>
                <div class="mb-3">
                    <label for="Sexo tarea" class="form-label">Sexo tarea</label>
                    <input type="text" class="form-control" id="Sexo tarea" name="anio" value="<?php echo htmlspecialchars($tareaBuscar['sexo_tarea']) ?>"  <?php disableOactive()?>>
                </div>
                <div class="mb-3">
                    <label for="Salario Base" class="form-label">Salario Base</label>
                    <input type="text" class="form-control" id="Salario Base" name="Salario Base" value="<?php echo htmlspecialchars($tareaBuscar['salario_base']) ?>"  <?php disableOactive()?>>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Guardar Tarea</button>
                </div>
            </form>
        </div>
    </div>
    <?php include "../footer.html"?>
</body>
</html>
