<?php
session_start();

// Inicializamos el array de errores
$errores = [];

// Lista de palabras a adivinar
$palabras = ["TELEFONO", "LAPIZ", "HOMBRE", "MUJER", "TELEVISOR", "CONSOLA", "LIBRO", "BETIS", "BRAZO", "TECLADO"];

// Verificamos si ya existe una palabra a adivinar en la sesión
if (!isset($_SESSION["palabraAdivinar"])) {
    // Si no hay una palabra guardada en la sesión, seleccionamos una aleatoria
    $_SESSION["palabraAdivinar"] = $palabras[rand(0, count($palabras) - 1)];
}

// Guardamos la palabra seleccionada
$palabraAdivinar = $_SESSION["palabraAdivinar"];
$longitudPalabra = strlen($palabraAdivinar);

// Inicializamos los huecos si no están definidos
if (!isset($_SESSION["huecos"])) {
    $_SESSION["huecos"] = str_repeat("-", $longitudPalabra);
}

// Verificar si la palabra ha sido enviada por el formulario
if (isset($_GET["submit"])) {       
    $palabraIngresada = strtoupper(trim($_GET["palabra"])); // Convertimos a mayúsculas para hacer la comparación más fácil

    if (empty($palabraIngresada)) {
        $errores[] = "La cadena está vacía";
    } else if ($palabraIngresada == $palabraAdivinar) {
        echo "<br>HAS ACERTADO";
        session_destroy(); // Reiniciar juego
    } else if (strlen($palabraIngresada) == 1) {   
        for ($i = 0; $i < $longitudPalabra; $i++) {
            if ($palabraAdivinar[$i] == $palabraIngresada) {
                // Reemplaza el guion en la posición correspondiente
                $_SESSION["huecos"][$i] = $palabraIngresada;
            }
        }
        // Imprimir la cadena huecos correctamente
        echo "<br>" . $_SESSION["huecos"];
    } else {
        echo "<br>Intenta de nuevo";
    }
} else {
    $errores[] = "No se puede enviar la cadena vacía";
}

// Mostrar errores si existen
if (!empty($errores)) {
    foreach ($errores as $error) {
        echo "<br>" . $error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ahorcado</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>

<form method="get">
  <div class="form-group row">
    <label for="text" class="col-4 col-form-label">Palabra</label> 
    <div class="col-8">
      <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <i class="fa fa-address-card"></i>
          </div>
        </div> 
        <input id="palabra" name="palabra" type="text" class="form-control" required="required">
      </div>
    </div>
  </div> 
  <div class="form-group row">
    <div class="offset-4 col-8">
      <button name="submit" type="submit" class="btn btn-primary">Submit</button>
    </div>
  </div>
</form>


</body>
</html>