<?php
global $wpdb;

$fondoConf = "{$wpdb->prefix}evento_fondo_conf";

// Obtener todos los registros
$queryFondo = "SELECT * FROM $fondoConf";
$listaFonConf = $wpdb->get_results($queryFondo, ARRAY_A);
if (empty($listaFonConf)) {
    $listaFonConf = array();
}

$tConfig = json_encode($listaFonConf, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
echo $tConfig;