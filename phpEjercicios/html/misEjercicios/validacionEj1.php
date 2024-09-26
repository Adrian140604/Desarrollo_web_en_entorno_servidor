<?php

    if(empty($_POST["nombre"])|| empty(($_POST["edad"]))){
        print("No esta permitido introducir campos vacios");
    }
    else{
        if(!is_numeric($_POST["edad"])){
            print ("Por favor introduce un numero valido");
        }
        else if(!(intval($_POST["edad"])>=0) || !(intval($_POST["edad"])<=100)){ //El ! se aplica a cualquier cosa
            print("La edad debe de estar entre 0 y 100");
        }
        else{
            print("Bienvenido ".htmlspecialchars($_POST["nombre"]." "."tienes ".htmlspecialchars($_POST["edad"])." años"));
        }


    }
    
?>