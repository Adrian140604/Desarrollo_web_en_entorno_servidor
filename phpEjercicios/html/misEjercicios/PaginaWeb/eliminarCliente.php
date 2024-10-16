<?php
function eliminaCliente($id, &$data) {
        foreach ($data as $key => $cliente) {
            if ($cliente['id'] == $id) {
                unset($data[$key]);
                return $data;
            }
        }
}

?>