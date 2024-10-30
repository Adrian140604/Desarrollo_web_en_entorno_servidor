<?php 
function disableOactive (){
    if($_GET["action"]=="verMas"||$_GET["action"]=="eliminar"){
        echo "disabled";
    }
    else{
        echo "required";
    }

}

function valoraAccion(){
    if($_GET["action"]=="verMas"){
        echo "Mostrando Una Tarea";
    }
    elseif($_GET["action"]=="aniadir"){
        echo "Dar de Alta una Tarea";

    }
    elseif($_GET["action"]=="editar"){
        echo "Editar Una Tarea";
    }
    else{
        echo "Elimina Tarea";
    }

}


?>