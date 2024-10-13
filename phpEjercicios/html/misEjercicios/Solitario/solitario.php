<?php
$svgFile = 'c1.svg'; // Cambia esto a la ruta de tu archivo SVG
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar SVG</title>
</head>
<body>
    <h1>Imagen SVG</h1>
    <div>
        <?php
        // Usa file_get_contents para leer el contenido del archivo SVG
        echo file_get_contents($svgFile);
        ?>
    </div>
</body>
</html>