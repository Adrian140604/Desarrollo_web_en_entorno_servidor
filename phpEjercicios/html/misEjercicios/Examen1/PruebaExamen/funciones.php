<?php
require_once("./database.php");

    function valoraAccion(){
        if($_GET["action"]=="verMas"){
            echo"Mostrando Cliente";
        }
        else if($_GET["action"]== "editar"){
            echo "Editando Cliente";
        }
        else if ($_GET["action"]== "aniadir"){
            echo "Añadiendo Cliente";
        }
        else if ($_GET["action"]== "registrar"){
            echo "Registrar nuevo";

        }
        else{
            echo "Borrando Cliente";
        }
    }
    function disabledOrNot(){
        if($_GET["action"]=="verMas"||$_GET["action"]=="eliminar"){
            echo"disabled";
        }
        else{
            echo "required";
        }

    }

    function encuentraCliente($datos,$id){
        foreach($datos as $cliente){
            if($cliente["id"]==$id){
                return $cliente;
            }
                

        }
    }

    function botones(){
        if($_GET["action"]=="verMas"){
            echo"<a href=\"./index.php\" name=\"opcion\" class='btn btn-info'>Volver Atras</a>";
        }
        else if($_GET["action"]== "editar"){
            echo "<button type=\"submit\" name=\"opcion\" value=\"editado\" class=\"btn btn-primary\">Editar</button>";
            echo"<a href=\"./index.php\" class='btn btn-info'>Volver Atras</a>";
        }
        else{
            echo "<button type=\"submit\" name=\"opcion\"  value=\"eliminado\" class=\"btn btn-primary\">Eliminar</button>"; //Hay que poner nombre y valor en el caso de que sea un boton , si es un enlace podemos poner action 
            echo"<a href=\"./index.php\" class='btn btn-info'>Volver Atras</a>";

        }
    }

    function eliminaCliente(&$datos,$id){ //Recordad poner el & para trabajr por referencias
        foreach($datos as $key => $cliente ){
            if($cliente["id"]==$id){
                unset($datos[$key]);
                return $datos;
            }
        }
    }
    
    function editaCliente(&$datos,$idAntiguo,$idNuevo,$nombreNuevo,$apellidoNuevo,$generoNuevo,$direccionNueva){
        foreach($datos as &$cliente){
            if($cliente["id"]==$idAntiguo){
                $cliente["id"]= $idNuevo;
                $cliente["name"]= $nombreNuevo;
                $cliente["surname"]=$apellidoNuevo;
                $cliente["gender"]=$generoNuevo;
                $cliente["address"]=$direccionNueva;
                return $datos;
            }

        }

    }
    
?>