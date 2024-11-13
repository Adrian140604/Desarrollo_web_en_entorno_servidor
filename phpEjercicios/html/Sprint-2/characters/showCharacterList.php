<?php 
require("./../functions/Database.php");
$connection = Database::getInstance()->getConnection();
require("./../components/header.php");
require("./../functions/characterFunctions.php");
?>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h2 class="text-center my-5">Lista de personajes</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="./formCharacters.php?formAction=addCharacter" class="btn btn-success my-5">Añadir Personaje</a>
        </div>
    </div>
    
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col" class="text-end">Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php listCharacters($connection); ?>
        </tbody>
    </table>
</div>

<?php 
require("./../components/footer.php");
?>

