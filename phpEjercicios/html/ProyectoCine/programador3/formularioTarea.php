<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../cabecera_footer.css">
</head>
<body>
    <?php include "../cabecera.html"?>
    <div class="container d-flex justify-content-center align-items-center h-100">
        <div class="card shadow-lg p-4 w-100" style="max-width: 600px;">
            <h2 class="text-center mb-4">Dar de Alta una Tarea</h2>
            
            <form action="procesar_pelicula.php" method="POST">
                <div class="mb-3">
                    <label for="Actor Principal" class="form-label">Actor Principal</label>
                    <input type="text" class="form-control" id="Actor Principal" name="Actor Principal" placeholder="Actor Principal de la pelicula" required>
                </div>
                <div class="mb-3">
                    <label for="Actor Secundario" class="form-label">Actor Secundario</label>
                    <input type="text" class="form-control" id="Actor Secundario" name="anio" placeholder="Actor Secundario" required>
                </div>
                <div class="mb-3">
                    <label for="Actriz Principal" class="form-label">Actriz Principal</label>
                    <input type="text" class="form-control" id="Actriz Principal" name="Actriz Principal" placeholder="Actriz Principal de la pelicula">
                </div>
                <div class="mb-3">
                    <label for="ActrizSecundaria" class="form-label">Actriz Secundaria</label>
                    <input type="text" class="form-control" id="ActrizSecundaria" name="ActrizSecundaria" placeholder="Actriz Secundaria de la pelicula" required>
                </div>
                <div class="mb-3">
                    <label for="Director" class="form-label">Director</label>
                    <input type="text" class="form-control" id="Director" name="Director" placeholder="Director de la pelicula" required>
                </div>
                <div class="mb-3">
                    <label for="Productor" class="form-label">Productor</label>
                    <input type="text" class="form-control" id="Productor" name="Productor" placeholder="Productor de la pelicula" required>
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Guardar Tarea</button>
                </div>
            </form>
        </div>
    </div>
    <?php include "../footer.html"?>
</body>
</html>
