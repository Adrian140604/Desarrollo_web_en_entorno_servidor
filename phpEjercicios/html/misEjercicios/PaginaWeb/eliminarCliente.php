<?php
function eliminaCliente($id, &$data) {
    if($_SERVER['REQUEST_METHOD']=='POST'){
        foreach ($data as $key => $cliente) {
            if ($cliente['id'] == $id) {
                unset($data[$key]);
                return $data;
            }
        }
    }
        
}

?>