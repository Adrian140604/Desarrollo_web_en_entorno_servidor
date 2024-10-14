<?php
session_start();

if (isset($_GET["reiniciar"])) {
    // Reiniciar el juego
    $_SESSION["imagenesMostrar"] = []; // Reiniciar la variable de imágenes
    $_SESSION["victorias"] = 0; // Reiniciar victorias
    $_SESSION["derrotas"] = 0; // Reiniciar derrotas
}

if (isset($_GET["jugar"])) {
    $imagenes = [
        "c1", "c2", "c3", "c4", "c5", "c6", "c7", "c8", "c9", "c10",
        "d1", "d2", "d3", "d4", "d5", "d6", "d7", "d8", "d9", "d10",
        "p1", "p2", "p3", "p4", "p5", "p6", "p7", "p8", "p9", "p10",
        "t1", "t2", "t3", "t4", "t5", "t6", "t7", "t8", "t9", "t10",
        "vacio"
    ];

    $_SESSION["imagenesMostrar"] = []; // Reiniciar la variable de imágenes
    if (!isset($_SESSION["victorias"]) && !isset($_SESSION["derrotas"])) {
        $_SESSION["victorias"] = 0;
        $_SESSION["derrotas"] = 0;
    }

    $gana = true;
    while (count($_SESSION["imagenesMostrar"]) < 10) { // Aquí hacemos un while para que no pare de añadir imágenes a imágenes mostrar hasta que ya haya 10
        $numeroAleatorio = rand(0, count($imagenes) - 1); // Así generamos un número aleatorio comprendido entre 0 y el número de cartas que haya
        if (!in_array($imagenes[$numeroAleatorio], $_SESSION["imagenesMostrar"])) { // Esto comprueba que en el array de imágenes mostrar no exista la imagen, o sea que no esté repetida
            $_SESSION["imagenesMostrar"][] = $imagenes[$numeroAleatorio];
        }  
    }

    foreach ($_SESSION["imagenesMostrar"] as $carta) {
        echo '<img src="./' . $carta . '.svg" alt="" height="200px" width="200px">'; // Aquí ponemos la ruta, ¡Mucho cuidado con las comillas!
    }

    for ($i = 1; $i <= count($_SESSION['imagenesMostrar']); $i++) {
        if ($i == substr($_SESSION['imagenesMostrar'][$i - 1], 1, 2)) {
            $gana = false;
        }
    }

    if ($gana) {
        $_SESSION["victorias"]++;
    } else {
        $_SESSION["derrotas"]++;
    }

    echo "<br/>";
    echo "Victorias: " . $_SESSION["victorias"] . "<br/>";
    echo "Derrotas: " . $_SESSION["derrotas"] . "<br/>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solitario</title>
</head>
<body>
    <div>
        <form action="" method="get">
            <button name="jugar" type="submit" class="btn btn-primary">Jugar</button>
            <button name="reiniciar" type="submit" class="btn btn-secondary">Reiniciar Juego</button> <!-- Botón para reiniciar el juego -->
        </form>
    </div>
</body>
</html>
