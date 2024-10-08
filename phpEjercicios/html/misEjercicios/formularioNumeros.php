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
    $errores = [];
    if(isset ($_GET["submit"])){
      if (isset($_GET["numero"])) {
        if (!empty($_GET["numero"])||$_GET["numero"]==0) {
          if(is_numeric($_GET["numero"])){
            $numero = $_GET["numero"];
            if ($numero > 0) {
                echo "El número es positivo.";
            } elseif ($numero < 0) {
                echo "El número es negativo.";
            } else {
                echo "El número es 0.";
            }

          }
          else{
            $errores[] = "El campo no es un numero";

          }
          
        } else {
            $errores[] = "El campo está vacío.";
        }
    } else {
        $errores[] = "Faltan valores para introducir.";
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
        <label for="numero" class="col-4 col-form-label">Número</label> 
        <div class="col-8">
          <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text">
                <i class="fa fa-balance-scale"></i>
              </div>
            </div> 
            <input id="numero" name="numero" type="number" class="form-control" required>
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
