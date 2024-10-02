<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
<?php
    $errores = [];

    // Verifica si los campos "usuario" y "contrasenia" han sido enviados
    if (isset($_GET["usuario"]) && isset($_GET["contrasenia"])) {
        // Verifica si los campos no están vacíos
        if (empty($_GET["usuario"])) {
            $errores[] = "El campo usuario está vacío";
        }
        
        if (empty($_GET["contrasenia"])) {
            $errores[] = "El campo contraseña está vacío";
        }
        
        // Solo verifica usuario y contraseña si ambos no están vacíos
        if (!empty($_GET["usuario"]) && !empty($_GET["contrasenia"])) {
            if ($_GET["usuario"] == "root" && $_GET["contrasenia"] == "root") {
                echo "Bienvenido";
            } else {
                $errores[] = "Usuario o contraseña incorrectos";
            }
        }
    } else {
        // Si no se enviaron los campos requeridos
        if (!isset($_GET["usuario"])) {
            $errores[] = "Falta el campo usuario";
        }
        if (!isset($_GET["contrasenia"])) {
            $errores[] = "Falta el campo contraseña";
        }
    }

    // Muestra todos los errores encontrados
    if (!empty($errores)) {
        foreach ($errores as $error) {
            echo "-" . $error . "<br>";
        }
    }
?>
<form method="get">
  <div class="form-group row">
    <label for="usuario" class="col-4 col-form-label">Usuario</label> 
    <div class="col-8">
      <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <i class="fa fa-address-card"></i>
          </div>
        </div> 
        <input id="usuario" name="usuario" type="text" required="required" class="form-control">
      </div>
    </div>
  </div>
  <div class="form-group row">
    <label for="contrasenia" class="col-4 col-form-label">Contraseña</label> 
    <div class="col-8">
      <input id="contrasenia" name="contrasenia" type="text" required="required" class="form-control">
    </div>
  </div> 
  <div class="form-group row">
    <div class="offset-4 col-8">
      <button name="submit" type="submit" class="btn btn-primary">Enviar</button>
    </div>
  </div>
</form>


    
</body>
</html>