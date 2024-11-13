<?php
function listhall($db){
  $query = "SELECT * FROM Sala"; // Query to execute in DB
  $stmt = $db->query($query); // Return and storage query result
  $halls = $stmt->fetchAll(PDO::FETCH_ASSOC); // Convert query result in associative array

  //Si hay salas lista todas las salas junto a su aforo
  if(empty($halls)){
      print "Sin salas";
  }else{
      foreach($halls as $key => $hall){
          if($_GET["cinema"]==$hall["cine"]){
              print "<tr>
              <td class='align-middle'>{$hall["sala"]}</td>
              <td class=text-end>{$hall["aforo"]}</td>
              </tr>";

          }
      }
  }

  print "</tbody>
                  </table>
                  <div class='col-12 text-end'>
                      <a class='btn btn-primary my-1' href='../cinema/showCinemasList.php'>Volver</a>
                  </div>";

}

function verifyRoom($roomName, $connection) {
  
    // Consulta SQL con cláusula WHERE para verificar si la sala existe
    $query = "SELECT 1 FROM Sala WHERE sala = :roomName LIMIT 1";
    $stmt = $connection->prepare($query); // Preparamos la consulta para evitar inyecciones SQL
    $stmt->bindParam(':roomName', $roomName, PDO::PARAM_STR); // Asociamos el parámetro para seguridad
    $stmt->execute(); // Ejecutamos la consulta

    // Si se encuentra un registro, fetch devolverá true; si no, false
    return $stmt->fetch() !== false;
}

function verifyCinema($cinemaN, $connection) {
    // Query with a WHERE clause to directly check for the cinema name
    $query = "SELECT 1 FROM Cine WHERE cine = :cinemaName LIMIT 1"; // Add LIMIT 1 for efficiency
    $stmt = $connection->prepare($query); // Use prepare for security (prevents SQL injection)
    $stmt->bindParam(':cinemaName', $cinemaN, PDO::PARAM_STR); // Bind parameter to avoid SQL injection
    $stmt->execute(); // Execute the query

    // If a record is found, fetch will return true, otherwise false
    $cinema = $stmt->fetch(PDO::FETCH_ASSOC);
    return $cinema ? $cinema['id'] : $cinema;
}

