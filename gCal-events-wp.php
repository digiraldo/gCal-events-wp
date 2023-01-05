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

if(!defined('ABSPATH')) die();

define("TEST_DIR",__FILE__);
define("TEST_PLUGIN_DIR",plugin_dir_path(TEST_DIR));
define("TEST_PLUGIN_URL",plugin_dir_url(TEST_DIR));
define("TEST_PLUGIN_NAME","TEST");
define("TEST_CANTIDAD_ELEMENTOS",12);

require_once TEST_PLUGIN_DIR ."/clases/principal.php";

# register_activation_hook(TEST_DIR, "activar");
register_activation_hook(TEST_DIR,array("principal","activar"));



?>