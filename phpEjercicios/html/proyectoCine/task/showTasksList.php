<?php 
    include '../components/header.php';
    include_once '../functions/tasksFunctions.php';
    
?>
<div class="container">
    <h2 class="text-center my-4">Lista de tareas</h2>
    <div class="row mb-2">
        <div class="col text-end">
            <a href="./formTasks.php?action=add" class="btn btn-success " >Añadir</a>
        </div>
    </div>
    <table class="table table-striped table-hover">
        <thead>
                <tr>
                    <th scope="col">Tarea</th>
                    <th scope="col">Sexo asignado</th>
                    <th scope="col" class="text-end">Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $tasks = getTasks();
                    if($tasks==null){
                        echo "<tr>
                                    <td class='align-middle'>No hay tareas que mostrar</td>
                                </tr>";
                    }else{
                        foreach($tasks as $task){
                            //Añadir función para transofmrar el sexo y que se lea diferente en el cliente.
                            $taskName = urlencode($task['tarea']);
                            $genderFormatted =  getGenderFormatForClient($task['sexo_tarea']);
                            echo "
                                <tr>
                                    <td class='align-middle'>{$task['tarea']}</td>
                                    <td class='align-middle'>{$genderFormatted}</td>
                                    <td class='text-end'>
                                        <a href='./formTasks.php?action=show&task={$taskName}' class='btn btn-outline-primary' >Ver más</a>
                                        <a href='./formTasks.php?action=edit&task={$taskName}' class='btn btn-outline-dark' >Editar</a>
                                        <a href='./formTasks.php?action=delete&task={$taskName}' class='btn btn-outline-danger' >Eliminar</a>
                                    </td>
                                </tr>";            
                        }                        
                    }

                ?>              
            </tbody>
    </div>

    </table>


</div>
<?php
    include '../components/footer.php';
?>