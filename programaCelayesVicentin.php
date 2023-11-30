 <?php
include_once("wordix.php");

/** Función que muestra el menú de opciones.
 * Pregunta al usuario y devuelve la opción elegida
 * @return int $opcionSeleccionada
 */

 function seleccionarOpcion() {
    // int $opcionSeleccionada
    echo "\nMENÚ DE OPCIONES: ¡WORDIX! \n";
    echo "1. Jugar al WORDIX con una palabra elegida. \n";
    echo "2. Jugar al WORDIX con una palabra aleatoria. \n";
    echo "3. Mostrar una Partida. \n";
    echo "4. Mostrar la primer partida ganadora. \n";
    echo "5. Mostrar resumen de Jugador. \n";
    echo "6. Mostrar listado de partidas ordenadas por JUGADOR y por PALABRA.\n";
    echo "7. Agregar una palabra de 5 letras a Wordix.\n";
    echo "8. Salir.\n\n";
    echo "OPCIÓN: ";
    $opcionSeleccionada = intval(trim(fgets(STDIN))); //intval toma la parte entera de un valor numérico, en caso de que se ingrese un float
    echo "\n";
    if (!(is_numeric($opcionSeleccionada)) || $opcionSeleccionada <= 0 || $opcionSeleccionada > 8) {
        $opcionSeleccionada = -1;
    }
    return $opcionSeleccionada;
}

/** Función que almacena 10 partidas iniciales
 * @return array $coleccionPartidas
 */
function cargarPartidas() {
    // array $coleccionPartidas
    $coleccionPartidas = [];
    $coleccionPartidas[0] = ["palabraWordix"=> "QUESO" , "jugador" => "majo", "intentos"=> 0, "puntaje" => 0];
    $coleccionPartidas[1] = ["palabraWordix"=> "CASAS" , "jugador" => "rudolf", "intentos"=> 0, "puntaje" => 0];
    $coleccionPartidas[2] = ["palabraWordix"=> "TINTO" , "jugador" => "derecha", "intentos"=> 4, "puntaje" => 14];
    $coleccionPartidas[3] = ["palabraWordix"=> "GOTAS" , "jugador" => "majo", "intentos"=> 0, "puntaje" => 0];
    $coleccionPartidas[4] = ["palabraWordix"=> "FIBRA" , "jugador" => "rudolf", "intentos"=> 3, "puntaje" => 13];
    $coleccionPartidas[5] = ["palabraWordix"=> "VERDE" , "jugador" => "pink2000", "intentos"=> 2, "puntaje" => 15];
    $coleccionPartidas[6] = ["palabraWordix"=> "NAVES" , "jugador" => "majo", "intentos"=> 0, "puntaje" => 0];    
    $coleccionPartidas[7] = ["palabraWordix"=> "TINTO" , "jugador" => "rudolf", "intentos"=> 1, "puntaje" => 17];
    $coleccionPartidas[8] = ["palabraWordix"=> "PISOS" , "jugador" => "pink2000", "intentos"=> 1, "puntaje" => 17];
    $coleccionPartidas[9] = ["palabraWordix"=> "GATOS" , "jugador" => "pink2000", "intentos"=> 6, "puntaje" => 11];
    return $coleccionPartidas;
}

/** Esta función verifica si existe un jugador ingresado dentro de la colección de partidas
 * @param string $nombre
 * @return bool
 */
function verificarJugador($nombre, $arregloPartidas) {
    // int $i
    // bool $band
    $i = 0;
    $band = false;
    for ($i = 0 ; $i < count($arregloPartidas) ; $i++) {
        if ($arregloPartidas[$i]["jugador"] == $nombre) {
            $band = true;
        }
    }
    return $band;
}

/** Función de la colección inicial de palabras a jugar
 * @return array
 */
function cargarColeccionPalabras()
{
    // array $coleccionPalabras que almacena datos tipo string
    $coleccionPalabras = [
        "MUJER", "QUESO", "FUEGO", "CASAS", "RASGO",
        "GATOS", "GOTAS", "HUEVO", "TINTO", "NAVES",
        "VERDE", "MELON", "YUYOS", "PIANO", "PISOS",
        "PLATO", "MILAN", "FIBRA", "DARIN", "RESTO"
    ];
    return ($coleccionPalabras);
}


/** Función que determina si el primer cáracter de el nombre de un jugador es letra o no
 * @param string $cadena
 * @return bool
 */
function primerLetra($cadena) {
    // int $cantCaracteres, $i
    // boolean $esLetra
    $esLetra = true;
    $esLetra =  ctype_alpha($cadena[0]);
        if($esLetra) {
            $resp = true;
        } else {
        $resp = false;
        }
    return $resp;
}

/** Función que solicita el nombre de un jugador y lo retorna en mayúsculas
 * @return string
 */
function solicitarJugador(){
    $band = 0;
    do {
        if ($band == 0) {
            echo "Ingrese el nombre del Jugador: ";
            $jug = strtolower(trim(fgets(STDIN)));
        } else {
            escribirRojo ("El nombre ingresado no es válido.");
            echo "\nIngrese el nombre del Jugador nuevamente: ";
            $jug = strtolower(trim(fgets(STDIN)));
        }
        $esCaracter = primerLetra($jug);
        $band += 1;
    } while (!($esCaracter)); 
    
    return $jug;
}

/** Función que verifica si una palabra ya ha sido jugada por el usuario.
 * @param array $arregloPartidas
 * @param string $nombre
 * @param string $palabraSeleccionada
 */
function verificarPalabraJugada($arregloPartidas, $nombre, $palabraSeleccionada) {
    $encontrada = false;
    $i = 0;
    while (!$encontrada && $i < count($arregloPartidas)) {
        if ($arregloPartidas[$i]["jugador"] == $nombre && $arregloPartidas[$i]["palabraWordix"] == $palabraSeleccionada) {
            $encontrada = true;
        }
        $i++;
    }
    return $encontrada;
}

/** Función para que se seleccione aleatoriamente
 * @param string $nombre
 * @param array $arregloPalabras
 * @param array $arregloPartidas
 * @return string $palabraAleat
 */
function palabraAleatoria($nombre, $arregloPalabras, $arregloPartidas) {
    // int $min, $max, $numAleatorio, $i
    $indiceAleatorio = random_int(0, count($arregloPalabras) - 1);
    while (verificarPalabraJugada($arregloPartidas, $nombre, $arregloPalabras[($indiceAleatorio)])) {
        $indiceAleatorio = random_int(0, (count($arregloPalabras) - 1));
        echo $indiceAleatorio . "\n";
    }
    return $arregloPalabras[$indiceAleatorio];
}

/** Función que muestra una partida basada en el número ingresado
 * @return int
 */
function mostrarPartida($coleccionDePartidas){
    //int $numMostrar
    //array $partidaPrint
    echo "MOSTRAR PARTIDA: \n";
    $indiceMostrar = solicitarNumeroEntre(1, count($coleccionDePartidas));
    return $indiceMostrar-1;
}

/** Función que retorna el índice de la primer partida ganada para luego mostrarlo con la función mostrarPartidaGanada
 * @param $arregloPartidas
 * @param $nombre
 * @return int
 */
function indicePrimerPartidaGanadora($arregloPartidas, $nombre) {
    //int $i, $retorna
    //bool $band
    $i = 0;
    $indice = -1;
    $encontrado = false;
    while ($encontrado == false && $i < count($arregloPartidas)) {
        if(($arregloPartidas[$i]["jugador"] == $nombre) && ($arregloPartidas[$i]["puntaje"] > 0)) {
            $encontrado = true;
            $indice = $i;
        }
        $i++;
    }
    return $indice;
}

/** Función que muestra la primer partida ganada de un jugador
 * @param $indicePartida
 */
function mostrarPartidaGanada($indicePartida, $arregloPatidas, $nombre) {
    if($indicePartida == -1){
        echo "\n";
        escribirRojo("el jugador ");
        escribirGris($nombre);
        escribirRojo(" no ganó ninguna partida");
        echo "\n\n";
    }
    else {
        echo "\n";
        echo "***************************\n";
        echo "Partida WORDIX ". $indicePartida+1 . ": palabra ". $arregloPatidas[$indicePartida]["palabraWordix"] . "\n";
        echo "Jugador: " . $nombre . "\n";
        echo "Puntaje: " . $arregloPatidas[$indicePartida]["puntaje"] . "\n";
        echo "Intento: Adivinó la palabra en " . $arregloPatidas[$indicePartida]["intentos"] . " intentos.\n";
        echo "***************************\n";
    }
}

/** Función que muestra las estadisticas de un jugador ingresado
 * @param array $arregloPartidas
 * @param string $nombre
 */
function arregloResumenJugador($arregloPartidas, $nombre) {
    // int $intento1, $intento2, $intento3, $intento4, $intento5, $intento6, $i, $partidasCont, $victorias, $puntajeTotal
    // float $porcentajeVictorias
    // array $arregloResumen
    $arregloResumen=[];
    $partidasCont = 0;
    $victorias = 0;
    $puntajeTotal = 0;
    $intento1 = 0;
    $intento2 = 0;
    $intento3 = 0;
    $intento4 = 0;
    $intento5 = 0;
    $intento6 = 0;
    for ($i = 0 ; $i < count($arregloPartidas) ; $i++) {
        if ($arregloPartidas[$i]["jugador"] == $nombre) {
            switch ($arregloPartidas[$i]["intentos"]) {
                case 1: 
                    $intento1++;
                    break;
                case 2: 
                    $intento2++;
                    break;
                case 3: 
                    $intento3++;
                    break;
                case 4: 
                    $intento5++;
                    break;
                case 5: 
                    $intento5++;
                    break;
                case 6: 
                    $intento6++;
                    break;
            }
            $partidasCont++;
            $puntajeTotal += $arregloPartidas[$i]["puntaje"];
            if (($arregloPartidas[$i]["puntaje"]) > 0) {
                $victorias++;
             }
         }
    }
    $porcentajeVictorias = ($victorias/$partidasCont)*100;
    $arregloResumen = [
        "jugador" => $nombre, "partidas" => $partidasCont, 
        "puntajeTotal" => $puntajeTotal, "victorias" => $victorias,
        "porcentaje" => $porcentajeVictorias,
        "intento1" => $intento1, "intento2" => $intento2, 
        "intento3" => $intento3, "intento4" => $intento4,
        "intento5" => $intento5, "intento6" => $intento6
    ];
    return $arregloResumen;  
}

/** Función que muestra el resumen de un jugador basado en los datos extraídos en la función arregloResumenJugador
 * @param array $resumen
 */
function escribirResumenJugador($resumen) {
    echo "*****************\n";
    echo "Jugador: " . $resumen["jugador"];
    echo "\nPartidas: " . $resumen["partidas"];
    echo "\nPuntaje Total: " . $resumen["puntajeTotal"];
    echo "\nVictorias: " . $resumen["victorias"];
    echo "\nPorcentaje Victorias: " . $resumen["porcentaje"] . "%";
    echo "\nAdivinadas: \n";
    for ($i = 1 ; $i < 7 ; $i++) {
    echo "          Intento ". $i . ": " . $resumen["intento".$i] . "\n";
    }
    echo "*****************\n";
}


/** Función que ordena a los jugadores alfabéticamente por nombre 1ero y luego los ordena alfabéticamente por palabra
 * @param array $a
 * @param array $b
 * @return int 
 */
function ordenarPorPalabra($a, $b) {
    //int $valor
    $valor = 0;
    if($a["jugador"] == $b["jugador"]){ //Consideramos que los jugadores ya están ordenados por la función anterior
        if($a["palabraWordix"] < $b["palabraWordix"]){
            $valor = -1;
        }else{
            $valor = 1;
        }
    }elseif($a["jugador"] < $b["jugador"]){
        $valor = -1;      
    }else{
        $valor = 1;
    }
    return $valor;
}

 /** Llama a las dos formas de ordenar y, con uasort, modifica el orden del arreglo 
  * @param array $arregloPartidas
  */
  function mostrarColeccionOrdenada($arregloPartidas){
    uasort($arregloPartidas, 'ordenarPorPalabra');
    print_r($arregloPartidas);   
}
 
/** Función que verifica si la palabra ingresada ya existe en el arreglo de Palabras
 * @param array $arregloPalabras
 * @param string $palabra
 * @return bool
 */
function verificarPalabra($arregloPalabras, $palabra) {
    //bool $band
    //int $i
    $band = false;
    for ($i = 0 ; $i < count($arregloPalabras) ; $i++) {
        if ($arregloPalabras[$i] == $palabra) {
            $band = true;
        }
    }
    return $band;
}

/** Función que pide una palabra de 5 letras y la retorna en mayúsculas
 * @return string
 */
function pedirPalabra($arregloPalabras) {
    $leerPalabra = leerPalabra5Letras();
    $condicion = verificarPalabra($arregloPalabras, $leerPalabra);
        while ($condicion){
            escribirRojo("PALABRA EXISTENTE: Ingrese otra palabra.");
            echo "\n";
            $leerPalabra = leerPalabra5Letras();
            $condicion = verificarPalabra($arregloPalabras, $leerPalabra);
        }

    return $leerPalabra;
}

/** Función que agrega una palabra al arreglo previo de la colección
 * @param array $arregloPalabras
 * @param string $palabra
 * @return array
 */
function agregarPalabra($arregloPalabras, $palabra){
    $long = count($arregloPalabras);
    $arregloPalabras[$long] = $palabra;
    return $arregloPalabras;
}

// PROGRAMA PRINCIPAL
/* MENÚ DE OPCIONES PARA INTERACTUAR */
$palabrasWordix = cargarColeccionPalabras();
$partidasWordix = cargarPartidas();
do {
    $opcion = seleccionarOpcion();
    if ($opcion <> -1) {
        switch ($opcion) {
            case 1:
                escribirVerde("JUGAR AL WORDIX CON UNA PALABRA ELEGIDA:");
                echo "\n\n";
                $jugador = solicitarJugador();
                $indicePalabraSeleccionada = solicitarNumeroEntre(1, count($palabrasWordix));
                $palabraSeleccionada = $palabrasWordix[($indicePalabraSeleccionada)-1];
                while (verificarPalabraJugada($partidasWordix, $jugador, $palabraSeleccionada) == true) {
                    escribirRojo("ERROR: La palabra ya ha sido jugada por el usuario.");
                    echo "\n";
                    $indicePalabraSeleccionada = solicitarNumeroEntre(1, count($palabrasWordix));
                    $palabraSeleccionada = $palabrasWordix[($indicePalabraSeleccionada)-1];
                }
                $partida = jugarWordix($palabraSeleccionada, $jugador);
                $partidasWordix[count($partidasWordix)] = $partida;
                break;
            case 2:
                escribirVerde("JUGAR AL WORDIX CON UNA PALABRA ALEATORIA:");
                echo "\n\n";
                $jugador = solicitarJugador();
                $palabraAleat = palabraAleatoria($jugador, $palabrasWordix, $partidasWordix);
                echo $palabraAleat . "\n";
                $partida = jugarWordix($palabraAleat, $jugador);
                $partidasWordix[count($partidasWordix)] = $partida;
                break;
            case 3:
                $indiceGanador = mostrarPartida($partidasWordix);
                $partidaPrint = $partidasWordix[$indiceGanador];
                echo "\n******************************\n";
                echo "Partida WORDIX ".($indiceGanador+1).": palabra ".$partidaPrint["palabraWordix"]."\n";
                echo "Jugador: ".$partidaPrint["jugador"]."\n";
                echo "Puntaje: ".$partidaPrint["puntaje"]."\n";
                if($partidaPrint["puntaje"] == 0){
                    echo "Intento: No adivinó la palabra.";
                }else{
                    echo "Intento: ".$partidaPrint["intentos"];
                }
                echo "\n******************************\n";
                break;
            case 4:
                do {
                    $jugador = solicitarJugador();
                    $condicion = verificarJugador($jugador, $partidasWordix);
                    if ($condicion) {
                        $indicePartida = indicePrimerPartidaGanadora($partidasWordix, $jugador);
                        mostrarPartidaGanada($indicePartida, $partidasWordix, $jugador);
                    }
                    else {
                        escribirRojo("Nombre inválido: El jugador no ha sido encontrado en el sistema.");
                        echo "\n";
                    }
                } while (!($condicion));
                break;
            case 5:
                do {
                    $jugador = solicitarJugador();
                    $condicion = verificarJugador($jugador, $partidasWordix);
                    echo "\n";
                    if ($condicion) {
                        $resumenJugador = arregloResumenJugador($partidasWordix, $jugador);
                        escribirResumenJugador($resumenJugador);
                    }
                    else {
                        escribirRojo("Nombre inválido: El jugador no ha sido encontrado en el sistema.");
                        echo "\n";
                    }
                } while (verificarJugador($jugador, $partidasWordix) == false);
                break;
            case 6:
                mostrarColeccionOrdenada($partidasWordix);
                break;
            case 7:
                $palab = pedirPalabra($palabrasWordix);
                echo "Palabra a agregar: " . $palab . "\n\n";
                $palabrasWordix = agregarPalabra($palabrasWordix, $palab);
                escribirVerde("PALABRA AGREGADA EXITOSAMENTE");
                echo "\n\n¿Desea ver la colección de palabras actuales?(s/n): ";
                $rta = trim(fgets(STDIN));
                if ($rta == "s" || $rta == "S") {
                    print_r($palabrasWordix);
                }
                break;
            }
        }
    else {
        escribirRojo("OPCION INCORRECTA: Vuelva a seleccionar.");
        echo "\n\n";
    }
} while ($opcion <> 8);