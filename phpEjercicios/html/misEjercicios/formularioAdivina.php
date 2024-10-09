<?php
    session_start();
    $errores=[];
    if (!isset($_SESSION["numeroAleatorio"])||!isset($_GET["submit"])) {
      $_SESSION["numeroAleatorio"] = rand(1, 100);
      $_SESSION["contador"] = 0;
    }
    if(isset($_GET["submit"])){
      if(!isset(($_GET["numero"]))){
        $errores[]="No hay ningun valor enviado";
      }
      else if(empty($_GET["numero"])){
        $errores[]= "El valor esta vacio";
      }
      else if (!is_numeric(value: $_GET["numero"])){
        $errores[]= "El numero introducido no es un numero";
      }
      else{
        $_SESSION["contador"]++;
        echo"Llevas: $_SESSION[contador] intentos";
        if($_GET["numero"]<$_SESSION["numeroAleatorio"]){
          echo "El numero es mayor";
        }
        else if($_GET["numero"]>$_SESSION["numeroAleatorio"]){
          echo "El numero es menor";
        }
        else{
          echo "Felicidades has acertado!";
          echo "Numero de intentos:$_SESSION[contador]";
         
          session_destroy();
  
        }
  
      }
    }  
    

    if (!empty($errores)) {
      foreach ($errores as $error) {
          echo "-" . $error . "<br>";
      }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
<form method="get">
  <div class="form-group row">
    <label for="numero" class="col-4 col-form-label">Numero</label> 
    <div class="col-8">
      <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <i class="fa fa-address-card"></i>
          </div>
        </div> 
        <input id="numero" name="numero" type="number" required="required" class="form-control">
      </div>
    </div>
  </div> 
  <div class="form-group row">
    <div class="offset-4 col-8">
      <button name="submit" type="submit" class="btn btn-primary">Enviar</button>
    </div>
  </div>
</form>


    
</body>
</html>