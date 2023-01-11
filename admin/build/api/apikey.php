<?php
global $wpdb;
$fondoConf = "{$wpdb->prefix}evento_fondo_conf";


switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Obtener todos los registros
        $queryFondo = "SELECT * FROM $fondoConf";
        $listaFonConf = $wpdb->get_results($queryFondo, ARRAY_A);
        if (empty($listaFonConf)) {
            $listaFonConf = array();
        }
        $tConfig = json_encode($listaFonConf, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        echo $tConfig;
        return;
        break;
}
$aqueryFondo = "SELECT * FROM $fondoConf";
$alistaFonConf = $wpdb->get_results($aqueryFondo, ARRAY_A);
if (empty($alistaFonConf)) {
    $alistaFonConf = array();
}
$atConfig = json_encode($alistaFonConf, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
//$atConfig = json_encode($alistaFonConf, true);
echo $atConfig;