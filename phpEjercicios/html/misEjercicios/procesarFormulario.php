<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        
        print ("Bienvenido ".htmlspecialchars($_GET["nombre"])."<br>"); //Asi se obtiene el nombre y el apellido, entre []se pone el nombre del campo que le hemos puesto
        //El punto funciona como una concatenacion
        //El htmlspecialchars() es una funcion que lo que hace es que no colapse el programa al poner caracteres especiales o bien cosas entre comillas
        $edad=intval($_GET["edad"]);
        //El intval pasa a numero lo que haya dentro del parentesis
        if(is_numeric(($_GET["nombre"]))){
            echo("El nombre no puede ser un numero");
        }
        if(empty($_GET["nombre"])){
            echo("El nombre esta vacio");
        }
        if(empty($_GET["edad"])){
            echo("La edad no puede estar vacia");
        }
        else{
            if($edad >= 18 ){
                print("Es mayor de edad");
            }
            else{
                print("Es menor de edad");
            }
        }
        
    ?>

</body>
</html>