<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio1</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
    <?php
    if(isset($_GET["nombre"])||isset($_GET["edad"])||isset($_GET["correo"])||isset($_GET["genero"])||isset($_GET["pais"])||isset($_GET["hobby"])){
        if(empty($_GET["nombre"])||empty($_GET["edad"])||empty($_GET["correo"])||empty($_GET["genero"])||empty($_GET["pais"])||empty($_GET["hobby"])){
            echo "Algun campo no esta relleno";
        }
        else{
            if(is_numeric($_GET["edad"])){
                $edad=intval($_GET["edad"]);
                if($edad<0|| $edad> 100){
                    echo "La edad tiene que estar comprendida entre 0 y 100";
                }
                else{
                    if($edad>=18){
                        echo "El usuario ".strtoupper($_GET["nombre"])." es mayor de edad";
                    }
                    else{
                        echo "El usuario ".strtoupper($_GET["nombre"])." es menor de edad";
                    }
                }


            }
            else{
                echo "La edad debe ser un valor numerico";
            }
            if($_GET["genero"]!="Masculino"&&$_GET["genero"]!="Femenino"&&$_GET["genero"]!="Otro"){
                echo"El genero introducido no es valido";
            }
        }

    }
    else{
        echo"Faltan datos por rellenar";
    }


    ?>
<form method="get">
  <div class="form-group row">
    <label for="nombre" class="col-4 col-form-label">Nombre</label> 
    <div class="col-8">
      <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <i class="fa fa-address-card"></i>
          </div>
        </div> 
        <input id="nombre" name="nombre" type="text" required="required" class="form-control">
      </div>
    </div>
  </div>
  <div class="form-group row">
    <label for="edad" class="col-4 col-form-label">Edad</label> 
    <div class="col-8">
      <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <i class="fa fa-blind"></i>
          </div>
        </div> 
        <input id="edad" name="edad" type="number" required="required" class="form-control">
      </div>
    </div>
  </div>
  <div class="form-group row">
    <label for="correo" class="col-4 col-form-label">Correo electronico</label> 
    <div class="col-8">
      <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <i class="fa fa-envelope-open-o"></i>
          </div>
        </div> 
        <input id="correo" name="correo" type="text" class="form-control" required="required">
      </div>
    </div>
  </div>
  <div class="form-group row">
    <label for="comentario" class="col-4 col-form-label">Comentario</label> 
    <div class="col-8">
      <textarea id="comentario" name="comentario" cols="40" rows="5" class="form-control"></textarea>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-4 col-form-label">Genero</label> 
    <div class="col-8">
      <div class="custom-controls-stacked">
        <div class="custom-control custom-radio">
          <input name="genero" id="genero_0" type="radio" required="required" class="custom-control-input" value="masculino"> 
          <label for="genero_0" class="custom-control-label">Masculino</label>
        </div>
      </div>
      <div class="custom-controls-stacked">
        <div class="custom-control custom-radio">
          <input name="genero" id="genero_1" type="radio" required="required" class="custom-control-input" value="femenino"> 
          <label for="genero_1" class="custom-control-label">Femenino</label>
        </div>
      </div>
      <div class="custom-controls-stacked">
        <div class="custom-control custom-radio">
          <input name="genero" id="genero_2" type="radio" required="required" class="custom-control-input" value="otro"> 
          <label for="genero_2" class="custom-control-label">Otro</label>
        </div>
      </div>
    </div>
  </div>
  <div class="form-group row">
    <label for="pais" class="col-4 col-form-label">Pais</label> 
    <div class="col-8">
      <select id="pais" name="pais" class="custom-select" required="required">
        <option value="españa">España</option>
        <option value="inglaterra">Inglaterra</option>
        <option value="italia">Italia</option>
        <option value="alemania">Alemania</option>
        <option value="indonesia">Indonesia</option>
      </select>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-4">Hobby</label> 
    <div class="col-8">
      <div class="custom-control custom-checkbox custom-control-inline">
        <input name="hobby" id="hobby_0" type="checkbox" class="custom-control-input" value="leer"> 
        <label for="hobby_0" class="custom-control-label">Leer</label>
      </div>
      <div class="custom-control custom-checkbox custom-control-inline">
        <input name="hobby" id="hobby_1" type="checkbox" class="custom-control-input" value="viajar"> 
        <label for="hobby_1" class="custom-control-label">Viajar</label>
      </div>
      <div class="custom-control custom-checkbox custom-control-inline">
        <input name="hobby" id="hobby_2" type="checkbox" class="custom-control-input" value="deportes"> 
        <label for="hobby_2" class="custom-control-label">Deportes</label>
      </div>
      <div class="custom-control custom-checkbox custom-control-inline">
        <input name="hobby" id="hobby_3" type="checkbox" class="custom-control-input" value="cerveza" checked="checked"> 
        <label for="hobby_3" class="custom-control-label">Cerveza</label>
      </div>
      <div class="custom-control custom-checkbox custom-control-inline">
        <input name="hobby" id="hobby_4" type="checkbox" class="custom-control-input" value="videojuegos"> 
        <label for="hobby_4" class="custom-control-label">Videojuegos</label>
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