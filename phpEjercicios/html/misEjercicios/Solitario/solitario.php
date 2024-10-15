<?php
    session_start();

    function notagain($list, $element) {
        $new = true;
        if (!empty($list)) {
            foreach ($list as $item) {
                if ($element == $item) { 
                    $new = false;
                }
            }
        }
        return $new;
    }

    function add ($array, $datarray) {
        $added = false;
        while (!$added) { 
            $randomnumber = random_int(0, count($datarray) -1);
            if (notagain($array, $datarray[$randomnumber])) { 
                $array[] = $datarray[$randomnumber];
                $added = true;
            }

        }
        return $array;
    }

    if (!isset($_SESSION["wins"]) && !isset( $_SESSION["defeats"])) {
        $_SESSION["wins"] = 0;
        $_SESSION["defeats"] = 0;
    } 

    $allcards = '../cartas/';
    $cards = [];

    $files = scandir($allcards);

    $cardshown = [];

    foreach ($files as $file) {
        if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['svg'])) {
            $cards[] = $allcards . $file;
        }
    }

    for ($i = 0; $i < 7; $i++) {
        $cardshown = add($cardshown, $cards);
        
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/solitario.css">
    <title>Solitario</title>
</head>
<body>
    <header>
        <h1>Solitario</h1>
    </header>

    
    
    <div class="tablero">
        <?php

            function victory($array) {
                $win = true;
                for ($i = 0; $i < count($array); $i++) {
                    $position = preg_replace('/[^0-9]/', '', $array[$i]);
                    if ($position == $i+1) {
                        $win = false;
                    }
                }
                return $win;
            }

            if (victory($cardshown)) {
                echo '<h1>'.'Has ganado'.'</h1>';
                $_SESSION["wins"]++;
            } else {
                echo '<h1>'.'Has perdido'.'</h1>';
                $_SESSION["defeats"]++;
            }

            foreach ($cardshown as $card) {

                echo '<img src="' . $card . '" style="width:200px;height: auto;">';

            }

        ?>

        <table>
            <?php
                echo '<tr>';
                echo '<td>Derrotas</td> ';
                echo '<td>Victorias</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td>'.$_SESSION["defeats"].'</td> ';
                echo '<td>'.$_SESSION["wins"].'</td> ';
                echo '</tr>';

            ?>
        </table>

    </div>
    
</body>
</html>