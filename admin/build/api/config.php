<?php
global $wpdb;

$fondoConf = "{$wpdb->prefix}evento_fondo_conf";
$textoPred = "{$wpdb->prefix}evento_texto_pred";
$switchTxt = "{$wpdb->prefix}evento_switch_texto";
/* */


// Establecer la configuración de cabecera HTTP adecuada
    # header('Content-Type: application/json');

    // Leer la solicitud HTTP y determinar el tipo de operación
    $method = $_SERVER['REQUEST_METHOD'];
    #echo $method;
    #echo "<br>";
    #echo $_GET['id_fondo'];

switch ($method) {
    case 'GET':
        if (!isset($_GET['id_fondo']) || !isset($_GET['id_texto']) || !isset($_GET['id_sw'])) {
            // Obtener todos los registros
            $queryFondo = "SELECT * FROM $fondoConf";
            $listaFonConf = $wpdb->get_results($queryFondo, ARRAY_A);
            if (empty($listaFonConf)) {
                $listaFonConf = array();
            }

            // Obtener todos los registros
            $queryText = "SELECT * FROM $textoPred";
            $listaTextPred = $wpdb->get_results($queryText, ARRAY_A);
            if (empty($listaTextPred)) {
                $listaTextPred = array();
            }

            $querySw = "SELECT * FROM $switchTxt";
            $listaSwText = $wpdb->get_results($querySw, ARRAY_A);
            if (empty($listaSwText)) {
                $listaSwText = array();
            }

            $fConfig = json_encode($listaFonConf, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            $tConfig = json_encode($listaTextPred, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            $sConfig = json_encode($listaSwText, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

            /* 
            file_put_contents(__DIR__.'../../json/fondo_config.json', $fConfig);
            file_put_contents(__DIR__.'../../json/texto_config.json', $tConfig);
	        file_put_contents(__DIR__.'../../json/switch_config.json', $sConfig);
             */

            // Ver los campos en formato JSON
            echo $fConfig;
            echo "<br>";
            echo $tConfig;
            echo "<br>";
            echo $sConfig;

            break;
        }

        // Obtener un registro en particular
        $id_fondo = intval($_GET['id_fondo']);
        $queryFondo = "SELECT * FROM $fondoConf WHERE id=$id_fondo";
        $listaFonConf = $wpdb->get_results($queryFondo, ARRAY_A);
        if (empty($listaFonConf)) {
            $listaFonConf = array();
        }

        // Devolver los campos en formato JSON
        echo json_encode($listaFonConf);
        break;
    
    case 'POST':
        if (!isset($_GET["opcion"])) {
            # code...
        }
        break;
    
    default:
        # code...
        break;
}


?>