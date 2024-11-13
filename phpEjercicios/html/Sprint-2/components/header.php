<!-- Contiene el header que se muestra en todas las páginas -->
 <?php $url= str_replace($_SERVER['DOCUMENT_ROOT'],"",__DIR__);?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinema Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href=<?php print $url . "/../styles/styles.css"?>>
</head>
<body class="d-flex flex-column min-vh-100">
    <header class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php print $url . "/../index.php"?>">Cinema</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="<?php print $url . "/../index.php"?>">Home</a>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Peliculas
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="<?php print $url.'/../showMoviesList.php';?>">Mostrar todas</a></li>
                    <li><a class="dropdown-item" href="<?php print $url.'/../formMovies.php?accion=add';?>">Agregar película</a></li>
                </ul>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Personajes
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="<?php print $url.'/../characters/showCharacterList.php';?>">Mostrar todos</a></li>
                    <li><a class="dropdown-item" href="<?php print $url.'/../characters/formCharacters.php?formAction=addCharacter';?>">Agregar personaje</a></li>
                </ul>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Tareas
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="<?php echo $url.'/../task/showTasksList.php';?>">Mostrar todas</a></li>
                    <li><a class="dropdown-item" href="<?php echo $url.'/../task/formTasks.php?action=add';?>">Agregar tarea</a></li>
                </ul>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Cines
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="<?php print $url.'/../cinema/showCinemasList.php';?>">Mostrar todos</a></li>
                    <li><a class="dropdown-item" href="<?php print $url.'/../cinema/formCinemas.php?cinemaAction=addCinema';?>">Agregar cine</a></li>
                </ul>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Proyecciones
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="<?php print $url.'/../screening/showScreeningList.php';?>">Mostrar todas</a></li>
                    <li><a class="dropdown-item" href="<?php print $url.'/../screening/formScreenings.php?screeningAction=addScreening';?>">Agregar Proyeccion</a></li>
                </ul>
                

                </li>
            </ul>
            </div>
            <a href="<?php print $url.'/../users/loginForm.php';?>" type="button" class="btn btn-outline-success mx-2">Iniciar Sesion</a>
            <a href="<?php print $url.'/../users/registerForm.php';?>" type="button" class="btn btn-outline-success mx-2">Registrarse</a>
            


        </div>
    </header>
