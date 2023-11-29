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
    $coleccionPartidas[1] = ["palabraWordix"=> "CASAS" , "jugador" => "rudolf", "intentos"=> 3, "puntaje" => 14];
    $coleccionPartidas[2] = ["palabraWordix"=> "TINTO" , "jugador" => "derecha", "intentos"=> 4, "puntaje" => 14];
    $coleccionPartidas[3] = ["palabraWordix"=> "GOTAS" , "jugador" => "majo", "intentos"=> 0, "puntaje" => 0];
    $coleccionPartidas[4] = ["palabraWordix"=> "FIBRA" , "jugador" => "rudolf", "intentos"=> 3, "puntaje" => 13];
    $coleccionPartidas[5] = ["palabraWordix"=> "VERDE" , "jugador" => "pink2000", "intentos"=> 2, "puntaje" => 15];
    $coleccionPartidas[6] = ["palabraWordix"=> "NAVES" , "jugador" => "majo", "intentos"=> 1, "puntaje" => 17];    
    $coleccionPartidas[7] = ["palabraWordix"=> "TINTO" , "jugador" => "rudolf", "intentos"=> 1, "puntaje" => 17];
    $coleccionPartidas[8] = ["palabraWordix"=> "PISOS" , "jugador" => "pink2000", "intentos"=> 1, "puntaje" => 17];
    $coleccionPartidas[9] = ["palabraWordix"=> "GATOS" , "jugador" => "pink2000", "intentos"=> 6, "puntaje" => 11];
    return $coleccionPartidas;
}

/** Agregar partida a la colección de partidas
 * @param array $partidaActual
 * @param array $coleccionPartidas
 * @param array 
 */
function agregarPartida($partidaActual, $coleccionDePartidas) {
    // int $cantPartidas
    $cantPartidas = count($coleccionDePartidas);
    $coleccionDePartidas[$cantPartidas] = $partidaActual;
    return $coleccionDePartidas;
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
            $resp=true;
        } else {
        $resp=false;
        }
    return $resp;
}

/** Función que solicita el nombre de un jugador y lo retorna en mayúsculas
 * @return string
 */
function solicitarJugador(){
    $cont=0;
    do {
        if($cont == 0){
            echo "Ingrese el nombre del Jugador: ";
            $jug = strtolower(trim(fgets(STDIN)));
        }else{
            escribirRojo ("El nombre ingresado no es válido.");
            echo "\nIngrese el nombre del Jugador nuevamente: ";
            $jug = strtolower(trim(fgets(STDIN)));
        }
        $esCaracter = primerLetra($jug);
        $cont += 1;
    } while(!($esCaracter)); 

    return $jug;
}

/** Función que pregunta al usuario un número entre un rango de valores
 * @return int
 */
function solicitarNumeroEntre($min, $max) {
    // int $numero
    echo "Ingrese un número entre ". $min . " y " . $max . ": ";
    $numero = trim(fgets(STDIN));

    if (is_numeric($numero)) { //determina si un string es un número. puede ser float como entero.
        $numero  = $numero * 1; //con esta operación convierto el string en número.
    }
    while (!(is_numeric($numero) && (($numero == (int)$numero) && ($numero >= $min && $numero <= $max)))) {
        escribirRojo("Número inválido.");
        echo "\nDebe ingresar un número entre " . $min . " y " . $max . ": ";
        $numero = trim(fgets(STDIN));
        if (is_numeric($numero)) {
            $numero = $numero * 1;
        }
    }
    return $numero;
}

/** Función que retorna una palabra seleccionada
 * @param string $nombre
 * @return string $palabraSeleccion
 */
function palabraSeleccionada($nombre, $arregloPalabras, $arregloPartidas) {
    // int $numero, $i
    // array $palabraSeleccion
    $numero = solicitarNumeroEntre(1, count($arregloPalabras));
    for ($i = 0; $i < count($arregloPartidas); $i++) {
        while ($arregloPartidas[$i]["jugador"] == $nombre && $arregloPartidas[$i]["palabraWordix"] == $arregloPalabras[$numero-1]) {
            escribirRojo("La palabra seleccionada ya ha sido jugada.");
            echo "\n";
            echo "Elija otro número: ";
            $numero = trim(fgets(STDIN));
        }
    }
        $palabraSeleccion = $arregloPalabras[$numero-1];
    return $palabraSeleccion;
}

/** Función para que se seleccione aleatoriamente
 * @param string $nombre
 * @param array $arregloPalabras
 * @param array $arregloPartidas
 * @return string $palabraAleat
 */
function palabraAleatoria($nombre, $arregloPalabras, $arregloPartidas) {
    // int $min, $max, $numAleatorio, $i
    $min = 0;
    $max = count($arregloPalabras) - 1;
    $numAleatorio = random_int($min, $max);
    $palabraAl = $arregloPalabras[$numAleatorio];
    for ($i = 0 ; $i < count($arregloPartidas) ; $i++) {
        while ($arregloPartidas[$i]["jugador"] == $nombre && $arregloPartidas[$i]["palabraWordix"] == $arregloPalabras[$numAleatorio]){
            echo $palabraAl . " ya ha sido jugada\n";
            $numAleatorio = random_int($min, $max);
        }
    }
    $palabraAl = $arregloPalabras[$numAleatorio];
    return $palabraAl;
}

/** Función que muestra una partida basada en el número ingresado
 * @return array
 */
function mostrarPartida($coleccionDePartidas){
    //int $numMostrar
    //array $partidaPrint
    echo "MOSTRAR PARTIDA: \n";
    $indiceMostrar = solicitarNumeroEntre(1, count($coleccionDePartidas));
    return $indiceMostrar-1;
}

/** Función que muestra la primer partida ganada
 * @param $arregloPartidas
 * @param $nombre
 * @return int
 */
function mostrarPrimerPartida($arregloPartidas, $nombre) {
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

/** Función que muestra las estadisticas de un jugador ingresado
 * @param array $arregloPartidas
 * @param string $nombre
 */
function escribirResumenJugador($arregloPartidas, $nombre) {
    // int $intento1, $intento2, $intento3, $intento4, $intento5, $intento6, $i, $partidasCont, $victorias, $puntajeTotal
    // float $porcentajeVictorias
    // array $arregloResumen

    $intento1 = 0;
    $intento2 = 0;
    $intento3 = 0;
    $intento4 = 0;
    $intento5 = 0;
    $intento6 = 0;
    for ($i = 0 ; $i < count($arregloPartidas) ; $i++) {
        if ($arregloPartidas[$i]["jugador"] == $nombre) {
            if ($arregloPartidas[$i]["intentos"] == 1) {
                $intento1++;
            }
            elseif ($arregloPartidas[$i]["intentos"] == 2) {
                $intento2++;
            }
            elseif ($arregloPartidas[$i]["intentos"] == 3) {
                $intento3++;
            }
            elseif ($arregloPartidas[$i]["intentos"] == 4) {
                $intento4++;
            }
            elseif ($arregloPartidas[$i]["intentos"] == 5) {
                $intento5++;
            }
            elseif ($arregloPartidas[$i]["intentos"] == 6) {
                $intento6++;
            }
        }
    }
    
     $arregloResumen=[];
    $partidasCont = 0;
    $victorias = 0;
    $puntajeTotal = 0;
     for($i = 0; $i < count($arregloPartidas) ; $i++) {
         if ($arregloPartidas[$i]["jugador"] == $nombre) {
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

/** Función que ordena a los jugadores alfabéticamente
 * @param array $a
 * @param array $b
 * @return int 
 */
function ordenarPorNombre($a, $b) {
    // Esta función ordena un arreglo alfabeticamente poniendo como prioridad el jugador
    // int $valor 
    $valor = 1;
    if ($a["jugador"] == $b["jugador"]) {
        $valor = 0;
    }
    elseif ($a["jugador"] < $b["jugador"]) { 
        $valor = -1;
    }
    else {
        $valor = 1;
    }
    return $valor;
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
    }
    return $valor;
}

 /** Llama a las dos formas de ordenar y, con uasort, modifica el orden del arreglo 
  * @param array $arregloPartidas
  */
  function mostrarColeccionOrdenada($arregloPartidas){
    uasort($arregloPartidas, 'ordenarPorNombre');
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
function ingresarPalabra() {
    //string $palabra
    //bool $condicion
    do {
        echo "Ingrese una palabra de 5 letras: ";
        $palabra = strtoupper(trim(fgets(STDIN)));
        
        while ((strlen($palabra) != 5) || !esPalabra($palabra)) {
            escribirRojo("ERROR: La palabra ingresada es inválida.");
            echo "\nDebe ingresar una palabra de 5 letras:";
            $palabra = strtoupper(trim(fgets(STDIN)));
        }
        $condicion = verificarPalabra(cargarColeccionPalabras(), $palabra);
        if ($condicion) {
            escribirRojo("PALABRA EXISTENTE: Ingrese otra palabra");
            echo "\n"; 
        }
    } while ($condicion == true);

    return $palabra;
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

/** Función que calcula el puntaje del jugador
 * @param int $intentos
 * @param string $palabra
 * @return int $puntajeTotal
 */
function obtenerPuntajeWordix($intentos, $palabra) {
    // int $intentosMaximos, $puntajeBase, $puntajeIntentos, $cantLetras, $cantVocales, $consAntesM, $consPostM, $puntAntesM, $puntPostM, $puntajeFinal
    // string $letra

    //Puntaje basado en los intentos
    $intentosMaximos = 6;
    $puntajeBase = 0;
    if ($intentos != 0) {
        while ($intentos <= $intentosMaximos) {
            $puntajeBase++;
            $intentosMaximos--;
        }
        $puntajeIntentos = $puntajeBase;

    //Puntaje basado en la palabra (vocales, consonantes antes y despúes de "M")
        $cantLetras = strlen($palabra);
        $cantVocales = 0;
        $consAntesM = 0;
        $consPostM = 0;
        for($i = 0 ; $i < $cantLetras ; $i++) {
            $letra = $palabra[$i];
            //condición para las vocales (1 punto)
            if (in_array($letra, ["A", "E", "I", "O", "U"])) { //funcion in_array que verifica si el elemento está dentro de los datos del arreglo comparado
                $cantVocales++;
            }
            //condición para las consonantes anteriores a M (inclusive)(2 puntos)
            if(in_array($letra, ["B", "C", "D", "F", "G", "H","J", "K", "L", "M"])) {
                $consAntesM++;
            }
            //condición para las consonantes posteriores a M (3 puntos);
            if(in_array($letra, ["N", "Ñ", "P", "Q", "R", "S", "T", "V", "W", "X", "Y", "Z"])) {
                $consPostM++;
            }
        }
        $puntAntesM = $consAntesM * 2;
        $puntPostM = $consPostM * 3;
        $puntajeFinal = $puntajeIntentos + $puntAntesM + $puntPostM + $cantVocales; 
    }
    return $puntajeFinal;
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
                echo "\n";
                $jugador = solicitarJugador();
                $palabraSelec = palabraSeleccionada($jugador, $palabrasWordix, $partidasWordix);
                $partida = jugarWordix($palabraSelec, $jugador);
                $partidasWordix = agregarPartida($partida, $partidasWordix);
                break;
            case 2:
                escribirVerde("JUGAR AL WORDIX CON UNA PALABRA ALEATORIA:");
                echo "\n\n";
                $jugador = solicitarJugador();
                $palabraAleat = palabraAleatoria($jugador, $palabrasWordix, $partidas);
                $partida = jugarWordix($palabraAleat, $jugador);
                $partidasWordix = agregarPartida($partida, $partidasWordix);
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
                    if (verificarJugador($jugador, $partidasWordix)) {
                        $indicePartida = mostrarPrimerPartida($partidasWordix, $jugador);
                        if($indicePartida == -1){
                            escribirRojo("Este jugador no ganó ninguna partida.");
                            echo "\n\n";
                        }
                        else {
                            escribirVerde("PRIMERA PARTIDA GANADA POR ");
                            escribirGris($jugador);
                            echo (": ");
                            echo "\n";
                            print_r($partidasWordix[$indicePartida]);
                        }
                    }
                    else {
                        escribirRojo("Nombre inválido: El jugador no ha sido encontrado en el sistema.");
                        echo "\n";
                    }
                } while (verificarJugador($jugador, $partidasWordix) == false);
                break;
            case 5:
                do {
                    $jugador = solicitarJugador();
                    if (verificarJugador($jugador, $partidasWordix)) {
                        $resumen = escribirResumenJugador($partidasWordix, $jugador);
                        echo "*****************\n";
                        echo "Jugador: " . $resumen["jugador"];
                        echo "\nPartidas: " . $resumen["partidas"];
                        echo "\nPuntaje Total: " . $resumen["puntajeTotal"];
                        echo "\nVictorias: " . $resumen["victorias"];
                        echo "\nPorcentaje Victorias: " . $resumen["porcentaje"] . "%";
                        echo "\nAdivinadas: \n";
                        echo "          Intento 1: ". $resumen["intento1"] ."\n";
                        echo "          Intento 2: ". $resumen["intento2"] ."\n";
                        echo "          Intento 3: ". $resumen["intento3"] ."\n";
                        echo "          Intento 4: ". $resumen["intento4"] ."\n";
                        echo "          Intento 5: ". $resumen["intento5"] ."\n";
                        echo "          Intento 6: ". $resumen["intento6"] ."\n";
                        echo "*****************\n";
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
                $palab = ingresarPalabra();
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