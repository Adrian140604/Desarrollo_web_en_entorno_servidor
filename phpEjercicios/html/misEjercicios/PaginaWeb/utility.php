<?php
function findCliente(&$data,$id){
    foreach ($data as $cliente) {
        if ($cliente['id'] == $id) {
            return $cliente;
        }
    }
        return null;
}
?>
