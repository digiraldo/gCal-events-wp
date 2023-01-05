<?php
/*
Plugin Name: gCal-events-wp
Plugin URI: https://github.com/digiraldo
Description: Eventos de Calendario de Google para tu Web, Muestra el calendario de Google como eventos dentro de una seccion de tu pagina web.
Version: 1.0.0
Author: digiraldo
Author URI: https://digiraldo.online/
License: MIT
License URL: https://www.mit.com
Text Domain: gCal-events-wp
*/
/*  Copyright 2022 digiraldo

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
// ####################################################################################################
// ####################################################################################################
// Cambiar nombre de lista_eventos.php por config_eventos.php
// ####################################################################################################
// ####################################################################################################
function activarCal(){
    global $wpdb;

	$sqlFondoConf ="CREATE TABLE IF NOT EXISTS {$wpdb->prefix}evento_fondo_conf(
		`id_fondo` INT NOT NULL,
		`api_key` VARCHAR(80) NOT NULL,
		`id_cal` VARCHAR(80) NOT NULL,
		`color_fondo` VARCHAR(10) NOT NULL,
		`color_bag_fec` VARCHAR(10) NOT NULL,
		`color_por_fec` VARCHAR(10) NOT NULL,
		`color_txt_fec` VARCHAR(10) NOT NULL,
		`color_bag_des` VARCHAR(10) NOT NULL,
		`color_por_des` VARCHAR(10) NOT NULL,
		`color_txt_tit` VARCHAR(10) NOT NULL,
		`color_txt_des` VARCHAR(10) NOT NULL,
		`color_bag_bot` VARCHAR(10) NOT NULL,
		`color_por_bot` VARCHAR(10) NOT NULL,
		`color_fon_btn` VARCHAR(10) NOT NULL,
		`color_tex_btn` VARCHAR(10) NOT NULL,
		PRIMARY KEY (`id_fondo`)
	)";

	$wpdb->query($sqlFondoConf);
	

	$dataFondoConf = "INSERT INTO {$wpdb->prefix}evento_fondo_conf (`id_fondo`, `api_key`, `id_cal`, `color_fondo`, `color_bag_fec`, `color_por_fec`, `color_txt_fec`, `color_bag_des`, `color_por_des`, `color_txt_tit`, `color_txt_des`, `color_bag_bot`, `color_por_bot`, `color_fon_btn`, `color_tex_btn`) VALUES
	(0, '', '', '#151719', '#3B3B3B', '', '#808080', '#364454', '', '#708090', '#D3D3D3', '#365444', '', '#D70026', '#FFFFFF')";
	
	$wpdb->query($dataFondoConf);

	$sqlTextoConf ="CREATE TABLE IF NOT EXISTS {$wpdb->prefix}evento_texto_pred(
		`id_texto` INT NOT NULL,
		`cal_title` VARCHAR(60) NOT NULL,
		`cal_fecha` VARCHAR(60) NOT NULL,
		`title_desc` VARCHAR(60) NOT NULL,
		`desc_evento` VARCHAR(400) NOT NULL,
		`title_location` VARCHAR(200) NOT NULL,
		`text_url` VARCHAR(60) NOT NULL,
		`text_btn` VARCHAR(45) NOT NULL,
		PRIMARY KEY (`id_texto`)
	)";

	$wpdb->query($sqlTextoConf);


	$dataTextoConf = "INSERT INTO {$wpdb->prefix}evento_texto_pred (`id_texto`, `cal_title`, `cal_fecha`, `title_desc`, `desc_evento`, `title_location`, `text_url`, `text_btn`) VALUES
	(0, 'Nuestros Programas', 'Pronto', 'Entrenamiento y Actividades', 'En el momento no tenemos programas habilitados, si quiere saber acerca de ellos o los programas que realizamos, lo invitamos dar click', 'Pronto', '#', 'Vamos')";

	$wpdb->query($dataTextoConf);

	$sqlSwTexto ="CREATE TABLE IF NOT EXISTS {$wpdb->prefix}evento_switch_texto(
		`id_sw` INT NOT NULL,
		`dato` VARCHAR(15) NOT NULL,
		`cal_id` VARCHAR(30) NOT NULL,
		`switch` VARCHAR(15) NOT NULL,
		`estado` VARCHAR(15) NOT NULL,
		`estatus` VARCHAR(5) NOT NULL,
		`col_btn` VARCHAR(30) NOT NULL,
		`type_btn` VARCHAR(30) NOT NULL,
		PRIMARY KEY (`id_sw`)
	)";

	$wpdb->query($sqlSwTexto);


	$dataSwTexto = "INSERT INTO {$wpdb->prefix}evento_switch_texto (`id_sw`, `dato`, `cal_id`, `switch`, `estado`, `estatus`, `col_btn`, type_btn) VALUES
	(0, '', '', '', 'Desactivado', 'off', 'btn-light', '')";

	$wpdb->query($dataSwTexto);
}

function desactivarCal(){
	global $wpdb;

	$sqlBorrarTablas = "DROP TABLE `wp_evento_fondo_conf`, `wp_evento_switch_texto`, `wp_evento_texto_pred`";

	$wpdb->query($sqlBorrarTablas);
}

function borrar(){}

register_activation_hook(__FILE__,'activarCal');
register_deactivation_hook(__FILE__,'desactivarCal');
register_uninstall_hook( __FILE__, 'borrar');

add_action( 'admin_menu','crearMenuCal');

function crearMenuCal(){
	add_menu_page(
        'Eventos Calendario',//Titulo de la pagina
        'Eventos gCal',// Titulo del menu
        'manage_options', // Capability
		plugin_dir_path(__FILE__).'admin/config_eventos.php', //slug
        null, //function del contenido
        plugin_dir_url(__FILE__).'admin/build/img/calendario.svg',//icono
        '100' //priority
    );
}

function mostrarContenidoCal(){
	echo "<h1>Contenido de la Pagina</h1>";
}

function guardarDatosJson(){
	global $wpdb;
	$fondoConfCal = "{$wpdb->prefix}evento_fondo_conf";
	$textoPredCal = "{$wpdb->prefix}evento_texto_pred";
	$switchTxtCal = "{$wpdb->prefix}evento_switch_texto";

	$queryFondoCal = "SELECT * FROM $fondoConfCal";
	$listaFonConfCal = $wpdb->get_results($queryFondoCal, ARRAY_A);
	if (empty($listaFonConfCal)) {
	$listaFonConfCal = array();
	}
	/*  */
	$fConfig = json_encode($listaFonConfCal, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); //
	file_put_contents(__DIR__.'../admin/build/json/fondo_config.json', $fConfig);


	$queryTextCal = "SELECT * FROM $textoPredCal";
	$listaTextPredCal = $wpdb->get_results($queryTextCal, ARRAY_A);
	if (empty($listaTextPredCal)) {
	$listaTextPredCal = array();
	}
	/*  */
	$tConfig = json_encode($listaTextPredCal, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); //
	file_put_contents(__DIR__.'../admin/build/json/lista_texto.json', $tConfig);


	$querySwCal = "SELECT * FROM $switchTxtCal";
	$listaSwTextCal = $wpdb->get_results($querySwCal, ARRAY_A);
	if (empty($listaSwTextCal)) {
	$listaSwTextCal = array();
	}
	/*  */
	$sConfig = json_encode($listaSwTextCal, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); //
	file_put_contents(__DIR__.'../admin/build/json/switch_config.json', $sConfig);
}

// ================================== Encolar js y css en backend ==================================
// ================================== Encolar js y css en backend ==================================

function encolarBootstrapJSCal($hook){
    //echo "<script>console.log('$hook')</script>";
    if($hook != "google-calendar-events-wp/admin/config_eventos.php"){
        return ;
    }
    wp_enqueue_script('bootstrapJs',plugins_url('admin/bootstrap/js/bootstrap.min.js',__FILE__),array('jquery'));
	wp_enqueue_script('jsExterno',plugins_url('admin/build/js/lista-eventos.js',__FILE__),array('jquery'));
    wp_enqueue_script('calendario',plugins_url('admin/build/js/eventos.js',__FILE__),array('jquery')); // js propio
}
add_action('admin_enqueue_scripts','encolarBootstrapJSCal');

function encolarBootstrapCSSCal($hook){
    if($hook != "google-calendar-events-wp/admin/config_eventos.php"){
        return ;
    }
    wp_enqueue_style('bootstrapCSS',plugins_url('admin/bootstrap/css/bootstrap.min.css',__FILE__));
    wp_enqueue_style('eventos',plugins_url('admin/build/css/app.css',__FILE__));  // css propio
}
add_action('admin_enqueue_scripts','encolarBootstrapCSSCal');


// ================================== Cargar Js y CSS en Frontend ==================================
// ================================== Cargar Js y CSS en Frontend ==================================

add_action ('wp_enqueue_scripts', 'cargar_frontend_js');
function cargar_frontend_js () {
  wp_enqueue_script( 'gCal', plugin_dir_url( __FILE__ ) . 'admin/build/js/eventos.js', array('jquery'), '1.0.0', true );
}

add_action ('wp_enqueue_scripts', 'cargar_frontend_css');
function cargar_frontend_css () {
	wp_enqueue_style( 'gCalCss', plugin_dir_url( __FILE__ ) . 'admin/build/css/app.css');
}


function mostrar_eventos($atts) {
	global $wpdb;

	$textoPred = "{$wpdb->prefix}evento_texto_pred";
	$switchTxt = "{$wpdb->prefix}evento_switch_texto";
	/* */ 
	$id = shortcode_atts( array(
	'id_corto' => '',
	'id_largo' => 'gcf-custom-template',
	), $atts );
	
	
	$queryText = "SELECT * FROM $textoPred";
	$listaTextPred = $wpdb->get_results($queryText);
	if (empty($listaTextPred)) {
		$listaTextPred = array();
	}
	
	$querySw = "SELECT * FROM $switchTxt";
	$listaSwText = $wpdb->get_results($querySw, ARRAY_A);
	if (empty($listaSwText)) {
		$listaSwText = array();
	}
	
	$a = shortcode_atts($listaTextPred[0], $atts );

  $texto = 
	'<div class="gCalFlow" id="' . $id['id_largo'] . '">' .
 '<div class="gcf-header-block">' .
   '<div class="gcf-title-block">' .
	 '<span class="gcf-title">' . $a['cal_title'] . '</span>' .
   '</div>' .
 '</div>' .
 '<hr size="1px" color="LightSlateGray" />' .
 '<div class="gcf-item-container-block">' .
   '<div class="gcf-item-block">' .
	 '<div class="gcf-item-header-block">' .
	   '<div class="gcf-item-date-block">' .
		 '<span class="gcf-item-daterange">' .
		   '<h2 class="no-margin"><span></span></h2>' .
		   '<br>' .
		   '<h3 class="no-margin">' . $a['cal_fecha'] . '<br><span></span></h3>' .
		 '</span>' .
	   '</div>' .
	 '</div>' .
	 '<div class="gcf-item-body-block">' .
	   '<div class="gcf-item-title-block">' .
		 '<strong class="gcf-item-title">' . $a['title_desc'] . '</strong>' .
	   '</div>' .
	   '<div class="gcf-item-description">' .
	     $a['desc_evento'] . 
	   '</div>' .
	   '<div class="gcf-item-location">' .
	   $a['title_location'] .
	   '</div>' .
	 '</div>' .
	 '<div class="btn-calendario">' .
	   '<a href="' . $a['text_url'] . '" class="boton-roja" role="button">' . $a['text_btn'] . '</a>' .
	 '</div>' .
   '</div>' .
 '</div>' .
 '<hr size="1px" color="LightSlateGray" />' .
 '<div class="gcf-last-update-block">' .
   'Ultima actualizacion: <span class="gcf-last-update"></span>' .
 '</div>' .
'</div>' .
'<br>'
// . '<div id="elemen"></div>'
;

    return $texto;
}
add_shortcode('eventos', 'mostrar_eventos');

?>

<!-- ========================Insertar CSS del Calendario de Google en las paginas======================== -->
<!-- ========================Insertar CSS del Calendario de Google en las paginas======================== -->

<?php 
add_action('wp_head', function(){
?>
<?php
global $wpdb;

$fondoConf = "{$wpdb->prefix}evento_fondo_conf";

$queryFondo = "SELECT * FROM $fondoConf";
$listaFonConf = $wpdb->get_results($queryFondo, ARRAY_A);
if (empty($listaFonConf)) {
  $listaFonConf = array();
}
?>

<!-- <link rel="stylesheet" href="<?php plugin_dir_url( __FILE__ ) . 'build/css/app.css'; ?>"> -->
<link rel="stylesheet" href="<?php plugins_url('build/css/app.css',__FILE__); ?>">

<style>
.gCalFlow .gcf-header-block .gcf-title-block .gcf-title {
    color: <?php echo $listaFonConf[0]['color_txt_tit']; ?>;
}

.gCalFlow .gcf-header-block .gcf-title-block .gcf-title a {
    color: <?php echo $listaFonConf[0]['color_txt_tit']; ?>;
}

.gCalFlow .gcf-header-block .gcf-title-block .gcf-title a:hover {
    color: <?php echo $listaFonConf[0]['color_txt_des']; ?>;
}

.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-header-block {
    background-color: <?php echo $listaFonConf[0]['color_bag_fec'] ,$listaFonConf[0]['color_por_fec']; ?>;
}

.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-header-block .gcf-item-date-block .gcf-item-daterange h2,
.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-header-block .gcf-item-date-block .gcf-item-daterange h3,
.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-header-block .gcf-item-date-block .gcf-item-daterange h4 {
    color: <?php echo $listaFonConf[0]['color_txt_fec']; ?>;
}

.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-body-block {
    background-color: <?php echo $listaFonConf[0]['color_bag_des'] ,$listaFonConf[0]['color_por_des']; ?>;
}

.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-body-block .gcf-item-title-block .gcf-item-title {
    color: <?php echo $listaFonConf[0]['color_txt_tit']; ?>;
}

.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-body-block .gcf-item-title-block .gcf-item-title a {
    color: <?php echo $listaFonConf[0]['color_txt_tit']; ?>;
}

.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-body-block .gcf-item-title-block .gcf-item-title a:hover {
    color: <?php echo $listaFonConf[0]['color_txt_fec']; ?>;
}

.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-body-block .gcf-item-description {
    color: <?php echo $listaFonConf[0]['color_txt_des']; ?>;
}

.gCalFlow .gcf-item-container-block .gcf-item-block .gcf-item-body-block .gcf-item-location {
    color: <?php echo $listaFonConf[0]['color_txt_tit']; ?>;
}

.gCalFlow .gcf-item-container-block .gcf-item-block .btn-calendario {
    background-color: <?php echo $listaFonConf[0]['color_bag_bot'] ,$listaFonConf[0]['color_por_bot']; ?>;
}

.gCalFlow .gcf-item-container-block .gcf-item-block .btn-calendario .boton-roja {
    background-color: <?php echo $listaFonConf[0]['color_fon_btn']; ?>;
    color: <?php echo $listaFonConf[0]['color_tex_btn']; ?>;
}

.gCalFlow .gcf-item-container-block .gcf-item-block .btn-calendario .boton-roja:hover {
    background-color: <?php echo $listaFonConf[0]['color_tex_btn']; ?>;
    color: <?php echo $listaFonConf[0]['color_fon_btn']; ?>;
}

.gCalFlow .gcf-last-update-block {
    color: <?php echo $listaFonConf[0]['color_txt_tit']; ?>;
}

.gCalFlow .gcf-last-update-block .gcf-last-update {
    color: <?php echo $listaFonConf[0]['color_txt_des']; ?>;
}

.btn-roja {
    background-color: <?php echo $listaFonConf[0]['color_fon_btn']; ?>;
    color: <?php echo $listaFonConf[0]['color_tex_btn']; ?>;
  }

.btn-roja:hover {
  background-color: <?php echo $listaFonConf[0]['color_tex_btn']; ?>;
  color: <?php echo $listaFonConf[0]['color_fon_btn']; ?>;
}
</style>
<?php 
} ,9999);
?>


<?php 
add_action('wp_footer', function(){
?>
<?php 
global $wpdb;
$fondoConfCal = "{$wpdb->prefix}evento_fondo_conf";

$queryFondoCal = "SELECT * FROM $fondoConfCal";
$listaFonConfCal = $wpdb->get_results($queryFondoCal, ARRAY_A);
if (empty($listaFonConfCal)) {
  $listaFonConfCal = array();
}
?>
<script>
	let id_cal = "<?php echo $listaFonConfCal[0]['id_cal']; ?>";
	let api_key = "<?php echo $listaFonConfCal[0]['api_key']; ?>";
</script>
<script src="/wordpress/wp-content/plugins/google-calendar-events-wp/admin/build/js/eventos.js"></script>
<?php
} ,1);
?>