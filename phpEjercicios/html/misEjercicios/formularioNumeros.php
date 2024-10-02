<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Numeros</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
    <?php
    $errores=[];
    if (isset($_GET["numero"])){
        if(!empty($_GET["numero"])||$_GET["numero"]==0){
            if($_GET["numero"]>0){
                echo "El numero es positivo";

            }
            else if($_GET["numero"]<0){
                echo "El numero es negativo";

            }
            else{
                echo "El numero es 0";
            }
        }
       

       
    }
    if (!isset($_GET["numero"])){
        $errores[]="Faltan valores para introducir"."<br>";
       
    }

    if (empty($_GET["numero"]&&$_GET["numero"]!=0)){
        $errores[]="El campo esta vacio"."<br>";
    }
    foreach ($errores as $error){
        echo"-".$error;
    }


    ?>

<form method="get">
  <div class="form-group row">
    <label for="text" class="col-4 col-form-label">Numero</label> 
    <div class="col-8">
      <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <i class="fa fa-balance-scale"></i>
          </div>
        </div> 
        <input id="numero" name="numero" type="number" class="form-control">
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