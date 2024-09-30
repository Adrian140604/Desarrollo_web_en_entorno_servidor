<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario2</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<form method="get">
  <div class="form-group row">
    <label for="text" class="col-4 col-form-label">Numero a multiplicar</label> 
    <div class="col-8">
      <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <i class="fa fa-calculator"></i>
          </div>
        </div> 
        <input id="numero" name="numero" type="number" class="form-control" required="required">
      </div>
    </div>
  </div> 
  <div class="form-group row">
    <div class="offset-4 col-8">
      <button name="submit" type="submit" class="btn btn-primary">Enviar</button>
    </div>
  </div>
</form>
<div>


    <?php
    if(isset($_GET["numero"])){
        $numero=intval($_GET["numero"]);
    }
    else{
        echo "No ha introducido ";
    }
    ?>
</div>

</body>
</html>