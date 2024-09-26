<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        
        print ("Bienvenido ".htmlspecialchars($_GET["nombre"])." ".htmlspecialchars($_GET["apellido"])); //Asi se obtiene el nombre y el apellido, entre []se pone el nombre del campo que le hemos puesto
        //El punto funciona como una concatenacion
        //El htmlspecialchars() es una funcion que lo que hace es que no colapse el programa al poner caracteres especiales o bien cosas entre comillas
        $edad=intval($_GET["edad"]);
        //El intval pasa a numero lo que haya dentro del parentesis
        var_dump(value:$edad);
        if($edad >= 18 ){
            print("Es mayor de edad");
        }
        else{
            print("Es menor de edad");
        }
    ?>

</body>
</html>