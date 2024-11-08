<?php 
    require("./components/header.php"); // Imports header
?>


<div class="alert alert-danger container text-center mt-4">
    <h5 class="alert-header">Ha ocurrido un error</h5>
    <?php  
    if(isset($_GET["msg"]) && !empty($_GET["msg"])){
        print $_GET["msg"]; // Prints the message.
    }else{
        print "Error. Página no encontrada.";
    }?>
</div>


<?php 
    require("./components/footer.php"); // Imports footer
?>