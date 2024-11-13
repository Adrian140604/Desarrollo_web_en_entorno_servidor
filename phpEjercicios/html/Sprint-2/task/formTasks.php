<?php
include '../components/header.php';
include_once ('../functions/tasksFunctions.php');
?>


    <?php
    $task =null;
    $action=null;
    if(isActionValidated()){
        $action = $_GET['action'];
    }else{
        echo "<script>window.location.href ='../error.php?msg=Error en la acción.'</script>";

    }
    
    
    if ($_SERVER['REQUEST_METHOD']=='GET'){
        if($action!='add'){
            if(isset($_GET['task'])){
                $task = validateTaskName($_GET['task']);
                if($task!=null){
                    $task = getTaskByName($task);
                    if($task==false){
                        echo "<script>window.location.href='../error.php?msg=La tarea no existe.'</script>";
                    }
                }else{
                    echo "<script>window.location.href='../error.php?msg=Identificador de la tarea inválido.'</script>";
                }
            }else{//Modificar mensaje de error.
                echo "<script>window.location.href='../error.php?msg=Identificadores inválidos para buscar la tarea.'</script>";
            }
        }
    }
    if ($_SERVER['REQUEST_METHOD']=='POST'){
        if(isset($_POST['addSubmit'])){
            [$taskName, $gender, $salary]= getVariablesIfValid();
            if ($taskName!=null && $gender!=null && !is_null($salary)){
                if(getTaskByName($taskName)==false){//It validates if this task already exists.
                    $taskAdded = addTask($taskName, $gender, $salary);
                    if($taskAdded==true){ //Ver si sacar esto y que sea válido tanto para editar como para añadir 
                        $task = getTaskByName($taskName);
                        $taskName = urlencode($task['tarea']);
                        echo "<div class='alert alert-success' role='alert'>
                                    Tarea agregada con éxito.
                                    <a href='./formTasks.php?action=show&task={$taskName}' class='btn btn-success' >Ver tarea</a></td>
                                </div>";  
                    }else{
                        echo "<div class='alert alert-danger' role='alert'>Error. La tarea no pudo ser registrada. Inténtelo de nuevo.</div>";  
                    }
                }else{
                    echo "<div class='alert alert-danger' role='alert'>Error. La tarea ya está registrada en el sistema</div>";  
                }
            }else{
                echo "<script>window.location.href='../error.php?msg=Variables de tarea ausentes o inválidas.'</script>";
            }
        }else if (isset($_POST['editSubmit']) || isset($_POST['deleteSubmit'])){
            $task = getTaskByName($_GET['task']);
            if($task ==false){
                echo "<div class='alert alert-danger' role='alert'>Error. La tarea no está registrada en el sistema</div>";  
            }else{//EDIT TASK
                if(isset($_POST['editSubmit'])){
                    $newGender = validateGender($_POST['gender']);
                    $newSalary = getSalaryIfValid($_POST['salary']);
                    $task = editTask($task, $newGender, $newSalary);
                    $action='alreadyUpdated';
                }else{//DELETE TASK
                    if(deleteTask($task)==true){
                        $action='alreadyDeleted';
                        echo "<div class='alert alert-success' role='alert'>Tarea eliminada con éxito. </div>";  
                    }else{
                        echo "<div class='alert alert-danger' role='alert'>Error. La tarea no pudo ser eliminada. </div>";  
                    }
                    
                }
            }
        }
    }

    

    ?>
    
    <form action="" method="post" class="mt-3 container mt-4" >
        <?php showHeaderForm($action); ?>
        <div class="row mb-3">
            <div class="col-md-3 offset-md-3">
                <label for="task" class="form-label" >Tarea</label>
            </div>    
            <div class="col-md-3">
                <input type="text" name="task" id="task" maxlength="30" placeholder="<?php echo getPlaceholder($action, "Nombre de la tarea", "tarea", $task); ?>" <?php  getReadonlyOrDisabled("tarea"); getRequired("task"); ?> class="form-control" >
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3 offset-md-3">
                <label for="task" class="form-label" >Género asociado</label>
            </div>    
            <div class="col-md-3">
                <select name="gender" id="gender" <?php getReadonlyOrDisabled(); getRequired()?> class="form-select">
                    <option value="H" <?php getSelected($task, "H")?>>Hombre</option>
                    <option value="M" <?php getSelected($task, "M")?> >Mujer</option>
                    <option value="O" <?php getSelected($task, "O")?> >Otros</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3 offset-md-3">
                <label for="task" class="form-label" >Salario base</label>
            </div>    
            <div class="col-md-3">
                <input type="number" name="salary" id="salary" min="0" max="9999999999" step="0.01" placeholder="<?php echo getPlaceholder($action, "Salario base de la tarea", "salario_base", $task)?>" <?php getReadonlyOrDisabled() ?> class="form-control" >
            </div>
        </div>
        <div class='row mb-3'>
            <div class='col-md-6 offset-md-3 d-flex justify-content-end'>
                <?php 
                    $url= str_replace($_SERVER['DOCUMENT_ROOT'],"",__DIR__);
                    showButtons($action, $task, $url);
                ?>
            </div>
        </div>
    </form>


<?php
include '../components/footer.php';
?>