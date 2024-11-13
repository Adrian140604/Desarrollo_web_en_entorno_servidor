<?
require_once("../functions/Database.php");
function registerUser($userName,$password){
    $errors=[];

    if(!isset($userName)||!isset($password)){
        $errors[]="Los valores usuario o contraseña no han sido enviados"


    }

}

?>