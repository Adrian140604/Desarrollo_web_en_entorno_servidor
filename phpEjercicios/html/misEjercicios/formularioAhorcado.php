<?php
session_start();
$errores=[];
$palabras=["MANZANA","TELESCOPIO","MOVIL","JUEZ","SANDRIA","ORDENADOR","TECLADO","CRUPIER","SILLA","ARMARIO"];
$_SESSION["intentos"]=0;
if(!isset($_SESSION["palabraAdivinar"])||!isset($_SESSION["longitudPalabraAdivinar"])){ //Aqui ponemos la condicion que solo cambie3 en el caso de que no este asignado, osea una vez se inicia el programa
  $_SESSION["palabraAdivinar"]=$palabras[rand(min: 0, max: 9)];
}

if(!isset($_GET["submit"])){
  for($i=0;$i<strlen($_SESSION["palabraAdivinar"]);$i++){
    $_SESSION["mostrar"].="-";
  }
  echo $_SESSION["mostrar"];
}

if(!isset($_GET["palabra"])){
  $errores[]="No hay datos enviados";
}
else if (empty($_GET["palabra"])){
  $errores[]="Hay valores vacios";
}
else{
  if(isset($_GET["submit"])){
    $_SESSION["longitudPalabraEsperada"]=strlen($_GET["palabra"]);
    
    for($i=0;$i<strlen($_SESSION["palabraAdivinar"]);$i++){     //Esto mide la longitud de la palabra
        if($_SESSION["palabraAdivinar"][$i]==$_GET["palabra"][$i]){
          $_SESSION["mostrar"].=$_SESSION["palabraAdivinar"][$i];
        }
        else{
          $_SESSION["mostrar"].="-";
        }
      
    }
    echo $_SESSION["mostrar"];
  }

}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ahorcado</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>

<form method="get">
  <div class="form-group row">
    <label for="text" class="col-4 col-form-label">Palabra</label> 
    <div class="col-8">
      <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <i class="fa fa-address-card"></i>
          </div>
        </div> 
        <input id="palabra" name="palabra" type="text" class="form-control" required="required">
      </div>
    </div>
  </div> 
  <div class="form-group row">
    <div class="offset-4 col-8">
      <button name="submit" type="submit" class="btn btn-primary">Submit</button>
    </div>
  </div>
</form>


</body>
</html>