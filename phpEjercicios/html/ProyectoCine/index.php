<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        require_once("database_cine.php");
        $conexion= Database::getInstance()->getConnection();
    ?>

    <?php
        $query="SELECT * FROM Pelicula";
        $stmt=$conexion->query($query);
        $clientes=$stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($clientes as $row){
            echo "Titulo: ".$row["titulo_p"].", Año producción: ".$row["ano_produccion"];
            echo"<br>";
        }
    ?>
</body>
</html>