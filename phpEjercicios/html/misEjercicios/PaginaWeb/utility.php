<?php
function findCliente(&$data,$id){
    foreach ($data as $cliente) {
        if ($cliente['id'] == $id) {
            return $cliente;
        }
    }
        return null;
}

function disableOrnot($accion){
    if($accion=="eliminar"||$accion=="verMas"){
        echo "disabled";
    }

}

function valoraAccion($accion){ //Recordar que no puede haber codigo html dentro de php, es decir con un echo sio que se puede pero al tener funciones php dentro podemos hacerlo asi 
    switch($accion){
        case "eliminar":
            echo "<h2 class=\"text-center mb-4\">Borrando Cliente</h2>";
            break;
        case "verMas":
            echo "<h2 class=\"text-center mb-4\">Mostrando Cliente</h2>";
            break;
        case "editar":
            echo "<h2 class=\"text-center mb-4\">Editando Cliente</h2>";
            break;

    }
}
?>

