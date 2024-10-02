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
    <?php
        $errores=[];
        if(isset($_GET["numero"])){
            if(!empty($_GET["numero"])){
                if(is_numeric($_GET["numero"])){
                    $numeroA=(rand(1,100));
                    if($_GET["numero"]==$numeroA){
                        echo"Acertastes";
                    }
                }
                
                
            }
        }
        else{
            if(!isset($_GET["numero"])){
                $errores[]="Faltan valores por enviar";
            }
            else if(empty($_GET["numero"])){
                $errores[]= "El campo esta vacio";
            }
            else{
                $errores[]= "El valor no es un numero";
            }
        }
        if (!empty($errores)) {
            foreach ($errores as $error) {
                echo "-" . $error . "<br>";
            }
        }
    ?>
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