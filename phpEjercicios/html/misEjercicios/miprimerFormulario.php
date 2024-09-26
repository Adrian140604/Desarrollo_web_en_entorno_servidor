<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Hola,bienvenido</h1>
    <form action="procesarFormulario.php" method="post">
        <div>
            Introduce tu nombre: <input type=text name="nombre" id="nombre" required>
        </div>
        <div>
            introduzca su edad: <input type="number" min="0" max="100" name= "edad" id="edad" required>
        </div>
        <div>
            <input type="submit" value="Enviar">
        </div>
    </form>
</body>
</html>