<?php 
require("./../functions/Database.php");
$connection = Database::getInstance()->getConnection();
require("./../components/header.php");
require("./../functions/characterFunctions.php");
?>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h2 class="text-center my-5">Filmografia</h2>
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

