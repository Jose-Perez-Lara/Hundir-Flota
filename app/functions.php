<?php

function getTablero($ataques,$tablero){
    
    $output='<h2>Tablero</h2><table border="1">';
    for ($i = 0; $i < 10; $i++){
        $output.='<tr>';
        for ($j = 0; $j < 10; $j++){
            $output.='<td>';
            if ($ataques[$i][$j]!=0) {
                $output.= $tablero[$i][$j] == 2 ? "X" : "O";
            } else {
                $output.="  ";
            }
            $output.='</td>';
        }
        $output.='</tr>';
    }
    $output.="</table>";

    return $output;
}

function setBarcos(){
    global $tablero;

    $barcos = array(
        "barco5" => 5,
        "barco4" => 4,
        "barco3-1" => 3,
        "barco3-2" => 3,
        "barco2" => 2
    );
    foreach($barcos as $barco => $tamanyo){
        $colocado = false;
        while (!$colocado) {
            $orientacion = rand(0, 1);
            $fila = rand(0, 9);
            $columna = rand(0, 9);
            if ($orientacion == 0 && $columna + $tamanyo <= 10) {
                if (comprobarEspacio($fila, $columna, $tablero,$orientacion,$tamanyo)) {
                    for ($i = 0; $i < $tamanyo; $i++) {
                        $tablero[$fila][$columna + $i] = 1;
                    }
                    $colocado = true;
                }
            } else {
                if (comprobarEspacio($fila, $columna, $tablero,$orientacion,$tamanyo)) {
                    for ($i = 0; $i < $tamanyo; $i++) {
                        $tablero[$fila][$columna + $i] = 1;
                    }
                    $colocado = true;
                }
            }
        }
    }
}

function comprobarEspacio($fila, $columna, $tablero,$orientacion,$tamanyo){
    $espacioLibre = true;
    switch ($orientacion) {
        case 0:
            for ($i = 0; $i < $tamanyo; $i++) {
                if ($tablero[$fila][$columna + $i] != 0) {
                    $espacioLibre = false;
                }
            }
        break;
        case 1:
            for ($i = 0; $i < $tamanyo; $i++) {
                if ($tablero[$fila + $i][$columna] != 0) {
                    $espacioLibre = false;
                }
            }
        break;
    }
    
    return $espacioLibre;
}

function getBodyOutput($ataques,$tablero,$victoria){
    if (!$victoria) {

        $bodyOutput = getTablero($ataques,$tablero);
        $bodyOutput .= '<h2>Introduce tus coordenadas de ataque</h2>
            <form action="index.php" method="post">
                <label for="fila">Fila (A-J)</label>
                <input type="text" name="fila" id="fila"required>
                <label for="columna">Columna (1-10)</label>
                <input type="number" name="columna" id="columna"required>
                <input type="hidden" name="tablero" value="'.serialize($tablero).'">
                <input type="hidden" name="ataques" value="'.serialize($ataques).'">
                <button type="submit">Atacar</button>
            </form>';
    }else{
        $bodyOutput = '<h2>GG</h2>
        <form method="post">
            <button type="submit">Reiniciar juego</button>
        </form>';
    }

    return $bodyOutput;

}

function isVictoria($tablero) {
    foreach ($tablero as $fila) {
        if (in_array(1, $fila)) {
            return false; 
        }
    }
    return true;
}
function dump($var){
    echo "<pre>". print_r($var, true) ."</pre>";
}