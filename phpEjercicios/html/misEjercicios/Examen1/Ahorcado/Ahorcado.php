<?php
    session_start();
 
    $palabras=["sandia","pera","futbol","mochila"];
    echo $_SESSION["palabraAdivinar"];
    echo"<br/>";
    $acertado=false;
    if(!isset( $_SESSION["palabraAdivinar"])&&!isset($_SESSION["intentos"])&&!isset($_SESSION["mostrarPantalla"])){
        $_SESSION["palabraAdivinar"]=$palabras[rand(0,count($palabras)-1)];
        $_SESSION["intentos"]=0;
        for($i= 0;$i<strlen($_SESSION["palabraAdivinar"])&&$acertado==false;$i++){
            $_SESSION["mostrarPantalla"]= $_SESSION["mostrarPantalla"]."-";
        }

    }

    if(isset($_GET["letra"])){
        if($_SERVER["REQUEST_METHOD"]){
            for($i=0;$i<strlen($_SESSION["palabraAdivinar"])&&$acertado==false;$i++){
                if($_SESSION["palabraAdivinar"]==strtolower($_GET["letra"])){
                    echo "Has acertado";
                    $acertado=true;
                }
                else if ($_SESSION["palabraAdivinar"][$i]==$_GET["letra"]){
                    $_SESSION["mostrarPantalla"][$i]=$_GET["letra"];
                   
                }
            
            }

        }
        echo $_SESSION["mostrarPantalla"];

   
   
  
    
    }
   echo $_SESSION["intentos"];

    if($_SESSION["intentos"]==6){
        echo "Perdiste";
        session_destroy();
    }
    if($acertado==true){
        session_destroy();
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
    <label for="text" class="col-4 col-form-label">Letra o Palabra</label> 
    <div class="col-8">
      <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <i class="fa fa-address-card"></i>
          </div>
        </div> 
        <input id="letra" name="letra" type="text" class="form-control">
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