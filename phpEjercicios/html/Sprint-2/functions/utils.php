<?php
require_once('Database.php');
$db = Database::getInstance()->getConnection();

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
/**
 * This function return true if the given variable is isset and not empty, or false if is
 * not isset or is empty. 
 * @param mixed $value
 * @return bool
 */
function issetNotEmpty($value){
    return (isset($_GET[$value]) && !empty($_GET[$value]));
}
/**
 * This void function shows the h1 header of the form page to create, delete, add or show a task.
 * @return void
 */
function showHeaderForm(){
    if(issetNotEmpty('action') && ($_GET['action']=='show' || $_GET['action']=='edit' || $_GET['action']=='delete' || $_GET['action']=='add')){
        $action = $_GET['action'];
        if($action=='show'){
            echo "<h2 class='mt-2 mb-2' >Detalles de la tarea</h2>";
        }else if ($action=='edit'){
            echo "<h2 class='mt-2 mb-2'>Editar tarea</h2>";
        }else if ($action=='delete'){
            echo "<h2 class='mt-2 mb-2'>Borrar tarea </h2>";
        }else {
            echo "<h2 class='mt-2 mb-2'>Añadir tarea</h2>";
        }
    }else{ // MANDAR A VENTANA DE ERROR
        echo "<div class=''> </div>";
    }
}
/**
 * It returns the task name without space to be send throught the get method. 
 * @param mixed $taskName
 * @return array|string
 */
function getTaskNameForGetMethod($taskName){
    return str_replace(' ', '', $taskName);
}

function getTaskByNameAndGender($taskName, $taskGender){
    $db = Database::getInstance()->getConnection();
    $query = 'SELECT * FROM cinema WHERE LOWER(tarea) = LOWER(:task) AND LOWER(sexo) = LOWER(:gender)';

    $stmt = $db->prepare($query);
    $stmt->bindParam(':task', $taskName);
    $stmt->bindParam(':gender', $taskGender);
    try{
        $stmt->execute();
    }catch (PDOException $e){
        $e->getMessage();
    }
    $task = $stmt->fetch(PDO::FETCH_ASSOC);
    
}




