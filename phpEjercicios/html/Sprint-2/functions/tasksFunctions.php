<?php
require_once('Database.php');
require_once('../functions/tasksFunctions.php');

/**
*Return an array of the tasks saved on Database.
* @return array
*/
function getTasks(){
    $db = Database::getInstance()->getConnection();
    $query = 'SELECT * FROM Tarea';
    $stmt = $db->query($query);
    $tasksArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $tasksArray;
}

function getTaskByName($taskName){
    $db = Database::getInstance()->getConnection();
    $query = 'SELECT * FROM cinema.Tarea WHERE UPPER(tarea) = UPPER(:task)';

    $stmt = $db->prepare($query);
    $stmt->bindParam(':task', $taskName);
    try{
        $stmt->execute();
    }catch (PDOException $e){
        die("Error de conexión: ".$e->getMessage());
    }
    $task = $stmt->fetch(PDO::FETCH_ASSOC);
    return $task;
}


/**
 * This functions validates if the action exists, is not empty and if its value is valid. 
 * @return bool
 */
function isActionValidated(){
    $isCorrect= false;
    if(isset($_GET['action'])) {
        $action = htmlspecialchars(trim($_GET['action']));
        if(!empty($action) && (($action=='add' || $action=='edit' || $action== 'delete' || $action=='show' || $action =='alreadyDeleted' || $action =='alreadyUpdated'))){
            $isCorrect= true;
        }
    }
    return $isCorrect;
}


// function getTaskNameFormatted($taskName){
//     $nameInArray = explode(' ',$taskName);
//     $nameFormatted = "";
//     foreach($nameInArray as $word){
//         if($word != " "){
//             $word[0]=strtoupper($word[0]);
//             $nameFormatted .=$word." ";
//         }
//     }
//     return trim($nameFormatted);
// }

/**
 * It validates whether the variables: task and gender are present, not empty and are valid, and if
 * the opcional variable salary if present, it has the right format. 
 * It returns an array (task, gender, salary). If a variable is null then is not valid. 
 */
function getVariablesIfValid(){
    if(isset($_POST['task']) && isset($_POST['gender'])){
        //Task name validation.
        $task = validateTaskName($_POST['task']);
        if ($task!=null){
            //Gender validation
            $gender = validateGender($_POST['gender']);
            if($gender!=null){
                //Salary validation.
                $salary = getSalaryIfValid($_POST['salary']);                
            }           
        }
    }else{//All task will be invalid if "task" or "gender" are not present.
        $task = null;
        $gender = null;
        $salary = null;
    }
    return [$task, $gender, $salary]; 
}
function validateTaskName($task){
    $task = trim(htmlspecialchars($task));
    $task = str_replace("  ", " ", $task); //Possible double space out. 
    if ((strlen($task)<=0) || (strlen($task)>30)){
        $task=null;
    }
    return $task;
}
function validateGender($gender){
    $gender = trim(htmlspecialchars($gender));
    if(!empty($gender) && (strlen($gender)==1) && ((strtoupper($gender)=='H') || (strtoupper($gender)=='M') || (strtoupper($gender)=='O'))){
        $gender = strtoupper($gender);
    }else{
        $gender = null;
    }
    return $gender;
}

/**
 * It returns the salary float value if salary is valid, null if it is not, and 0 if there salary value sended was null.  
 * @param mixed $salary
 * @return float|null
 */
function getSalaryIfValid($salary){
    if ($salary==null){
        $salary =0;
    }else{
        $salary = trim(str_replace(' ', '', $salary));
        $salary = str_replace ( ',', '.', $salary);
        $isNumeric = preg_match("/^[0-9]+([.][0-9]{1,2})?$/", $salary);
        if ($isNumeric===1 && ((float)$salary)>=0 && (float)$salary<9999999999){
            $salary= round(floatval($salary), 0, PHP_ROUND_HALF_UP);
        }else{
            $salary = null;
        }        
    }
    return $salary;
}


// CRUD FUNCTIONS
/**
 * This function return true if the element was added succefully or false otherwise. 
 * @param mixed $taskName
 * @param mixed $gender
 * @param mixed $salary
 * @return bool
 */
function addTask($taskName, $gender, $salary){
    $added = false;
    $db = Database::getInstance()->getConnection();
    $query = 'INSERT INTO Tarea (tarea, sexo_tarea, salario_base) VALUES (:task, :gender, :salary)';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':task', $taskName);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':salary', $salary);
    try{
        $stmt->execute();
    }catch(Exception $e){
        die("Error: ".$e->getMessage());
    }
    if($stmt->rowCount()>0){
        $added= true;
    }
    return $added;
}

function editTask($task, $newGender, $newSalary){
    $oldGender = $task['sexo_tarea'];
    //update the changes if they are valid.
    if($newGender==null){
        $newGender = $oldGender;
    }//update the changes if they are valid.
    if($newSalary==null){
        $newSalary = $task['salario_base'];
    }//We make sure the is not another data saved with the same task name and gender.
    if (getTaskByName($task['tarea'])==false){
        $task=false;
    }else{
        $db = Database::getInstance()->getConnection();
        $query = 'UPDATE Tarea SET sexo_tarea = :newGender, salario_base = :salary WHERE tarea = :taskName AND sexo_tarea = :oldGender';
        $stmt = $db->prepare($query);
        $stmt->bindParam(':newGender', $newGender);
        $stmt->bindParam(':salary', $newSalary);
        $stmt->bindParam(':taskName', $task['tarea']);
        $stmt->bindParam(':oldGender', $oldGender);
        try{
            $stmt->execute();
        }catch(Exception $e){
            die("Error: ".$e->getMessage());
        }
        if ($stmt->rowCount()>0){
            echo "<div class='alert alert-success' role='alert'>Tarea modificada con éxito. </div>";  
            $task = getTaskByName($task['tarea']);
        }else{
            echo "<div class='alert alert-danger' role='alert'>Error. La tarea no pudo ser modificada. </div>";  
        }
    }
    return $task;
}
function taskHasSons($task){
    $hasSons = false;
    $db = Database::getInstance()->getConnection();
    $query = 'SELECT * FROM Trabajo WHERE tarea = :taskName';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':taskName', $task['tarea']);
    try{
        $stmt->execute();
    }catch(Exception $e){
        die("Error: ".$e->getMessage());
    }
    if ($stmt->rowCount()>0){
        $hasSons=true;
    }   
    return $hasSons;    
}
/**
 * This functions returns true if the task send as param has no sons or if they have been successfully deleted.
 * It returns false if the sons could not be removed from the Database.
 * @param mixed $task
 * @return bool
 */
function deleteSons($task){
    $sonsDeleted = false;
    if(taskHasSons($task)){
        $db = Database::getInstance()->getConnection();
        $query = 'DELETE FROM Trabajo WHERE tarea = :taskName';
        $stmt = $db->prepare($query);
        $stmt->bindParam(':taskName', $task['tarea']);
        try{
            $stmt->execute();
        }catch(Exception $e){
            die("Error: ".$e->getMessage());
        }
        if ($stmt->rowCount()>0){
            $sonsDeleted= true;
        }     
    }else{
        $sonsDeleted=true;
    }
    return $sonsDeleted;
}
function deleteTask($task){
    $deleted = false;
    $db = Database::getInstance()->getConnection();
    $query = 'DELETE FROM Tarea WHERE tarea = :taskName AND sexo_tarea = :gender';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':taskName', $task['tarea']);
    $stmt->bindParam(':gender', $task['sexo_tarea']);
    try{
        $stmt->execute();
    }catch(Exception $e){
        die("Error: ".$e->getMessage());
    }
    if ($stmt->rowCount()>0){
        deleteSons($task);
        $deleted = true;
    }
    return $deleted;
}

//HTML VIEW RELATED FUNCTIONS

/**
 * This void function shows the h1 header of the form page to create, delete, add or show a task.
 * @return void
 */
function showHeaderForm($action){
        if($action=='show'){
            echo "<h2 class='text-center mb-4' >Detalles de la tarea</h2>";
        }else if ($action=='edit'){
            echo "<h2 class='text-center mb-4'>Editar tarea</h2>";
        }else if ($action=='delete'){
            echo "<h2 class='text-center mb-4'>Borrar tarea </h2>";
        }else if($action =='add'){
            echo "<h2 class='text-center mb-4'>Añadir tarea</h2>";
        }else if($action =='alreadyDeleted'){
            echo "<h2 class='text-center mb-4'>Detalles de la tarea eliminada</h2>";
        }else{
            echo "<h2 class='text-center mb-4'>Detalles de la tarea modificada</h2>";
        }
}

function getPlaceholder($action, $fieldNameInHTML, $fieldNameInDDBB, $task){
    $result ="Sin registro";
    if (strcmp($action, "add")==0){
        $result = $fieldNameInHTML;
        $result = $fieldNameInHTML;
    }else{
        if($task ==null){ //mirar si voy a recibir el dato como nulo o simplemente no va a existir en el array asociativo. Y si al llamar al array asociativo de algo que no existe simplemente es null o peta. 
            $result = "Sin registro";
        }else{
            if(strcmp($fieldNameInDDBB, "salario_base")==0 && $task["salario_base"]!=null){
                $result= $task[$fieldNameInDDBB]."€";
            }else if (strcmp($fieldNameInDDBB, "tarea")==0){
                $result= $task[$fieldNameInDDBB];
            if(strcmp($fieldNameInDDBB, "salario_base")==0 && $task["salario_base"]!=null){
                $result= $task[$fieldNameInDDBB]."€";
            }else if (strcmp($fieldNameInDDBB, "tarea")==0){
                $result= $task[$fieldNameInDDBB];
            }
        }
    }
}return $result;
}
/**This function print "checked" in the assigned task_gender. If no information is registered,
 * it select "M" (as woman) as the preselected choice. 
*/
function getSelected($task, $genderOption){
    if($task==null && $genderOption=="M"){
            echo "selected";
    }else if($task!=null){
        if($task['sexo_tarea']==$genderOption){
            echo "selected";
        }else if($task['sexo_tarea']=='N' && $genderOption=='O'){ //We make sure the data previusly saved in the database are correclty read ('Other' option is saved as 'N')
            echo "selected";
        }
    }
}
/**
 * This function print "disabled" if the action is show or delete the task; or "readonly" if the action is "edit" and the field is "task".
 * @param mixed $fieldNameInBBDD
 * @return void
 */
function getReadonlyOrDisabled($fieldNameInBBDD="none"){
    if(isset($_GET['action'])){ //Si llega aquí no debería validar esto, porque ya se habría validado antes.
        if(strcmp($_GET['action'], 'show')==0 || strcmp($_GET['action'], 'delete')==0){
            echo "disabled";
        }
        else if(strcmp($_GET['action'], 'edit')==0 && strcmp($fieldNameInBBDD, "tarea")==0){
            echo "readonly";
        }
    }
}

function getRequired($fieldNameInHTML="none"){
    if(isActionValidated()){
        if(($_GET['action']=='add' || ($_GET['action']=='edit') && $fieldNameInHTML!='task')){
            echo "required";
        }
    }
}

/**
 * This function prints the buttons of the form according to the action. 
 * @param mixed $action
 * @param mixed $task
 * @param mixed $url
 * @return void
 */
function showButtons($action, $task, $url){

    if (isActionValidated()){
        if(strcmp($action, 'show')==0 || strcmp($action, 'alreadyUpdated')==0 ){
            $taskName = urlencode($task['tarea']);
            echo "  <a href='{$url}/formTasks.php?action=edit&task={$taskName}' class='btn btn-outline-primary me-1' >Editar</a>
                        <a href='{$url}/formTasks.php?action=delete&task={$taskName}' class='btn btn-outline-danger me-1' >Eliminar</a>
                        <a href='{$url}/showTasksList.php' class='btn btn-primary me-1' >Volver a la lista</a>";
        }else if(strcmp($action, 'edit')==0){
            echo "<a href='{$url}/showTasksList.php' class='btn btn-outline-primary me-1' >Volver a la lista</a>
                <input type='submit' value='Guardar cambios' name='editSubmit' id='submit' class='btn btn btn-primary me-1' >";
        }else if(strcmp($action, 'delete')==0){
            echo "<a href='{$url}/showTasksList.php' class='btn btn-outline-danger me-1' >Volver a la lista</a>
                        <input type='submit' value='Confirmar eliminación' name='deleteSubmit' id='submit' class='btn btn-danger me-1' >";
        }else if(strcmp($action, 'add')==0){
            echo "<a href='{$url}/showTasksList.php' class='btn btn-outline-primary me-1' >Volver a la lista</a>
                        <input type='submit' value='Guardar' name='addSubmit' id='addSubmit' class='btn btn-primary me-1' >";
        }else if(strcmp($action, 'alreadyDeleted')==0){
            echo "<a href='{$url}/showTasksList.php' class='btn btn-dark me-1' >Volver a la lista</a>";
        }
    }
}

function getGenderFormatForClient($gender){
    $genderFormatted = false;
    if ($gender =='M'){
        $genderFormatted= 'Mujer';
    }else if ($gender == 'H'){
        $genderFormatted = 'Hombre';
    }else{
        $genderFormatted = 'Otros';
    }
    return $genderFormatted;
}