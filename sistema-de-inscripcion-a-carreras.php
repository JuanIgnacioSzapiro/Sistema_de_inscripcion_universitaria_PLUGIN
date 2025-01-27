<?php
/*
 * Plugin Name:       Plugin del Sistema de Inscripicón a Carreras INSPT
 * Plugin URI:        The home page of the plugin, which should be a unique URL, preferably on your own website. This must be unique to your plugin. You cannot use a WordPress.org URL here.Example: https://example.com/plugins/the-basics/
 * Description:       Sistema de inscripción a carreras del Instituto Nacional Superior del Profesorado Técnico
 * Version:           0.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Juan Ignacio Szapiro
 * Author URI:        https://github.com/JuanIgnacioSzapiro
 * License:           GPL v2 or later
 * License URI:       A link to the full text of the license. Example: https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       plugin-sistema-de-ingreso-a-carreras-INSPT
 */

if (!defined('ABSPATH')) { // si la busqueda de la página web no es del path absoluto que le da por default wordpress...
    die('Acceso no permitido');
} else {
    if (!class_exists('sistema_de_inscripcion_a_carreras')) {
        require_once dirname(__FILE__) . '/enque.php';
        require_once dirname(__FILE__) . '/activar_plugin.php';
        require_once dirname(__FILE__) . '/desactivar_plugin.php';
        require_once dirname(__FILE__) . '/desinstalar_plugin.php';

        class sistema_de_inscripcion_a_carreras
        {
            public function __construct()
            {
                add_action('init', array($this, 'activar_desactivar_desinstalar'));
            }

            public function activar_desactivar_desinstalar()
            {
                register_activation_hook(__FILE__, 'activar_plugin');

                // register_deactivation_hook(__FILE__, 'desactivar_plugin');

                // register_uninstall_hook(__FILE__, 'desinstalar_plugin');

                /*
                This table illustrates the differences between deactivation and uninstall.
                Scenario                 | Deactivation Hook | Uninstall Hook
                -------------------------|-------------------|----------------   
                Flush Cache/Temp         |       Yes         |       No
                -------------------------|-------------------|----------------
                Flush Permalinks         |       Yes         |       No
                -------------------------|-------------------|----------------
                Remove Options from      |       No          |       Yes
                {$wpdb->prefix}_options  |                   |
                -------------------------|-------------------|----------------
                Remove Tables from wpdb  |       No          |       Yes
                */

                register_deactivation_hook(__FILE__, 'desinstalar_plugin'); // USO EXCLUSIVO DE DEBUGGEO
            }
        }
    }
    new sistema_de_inscripcion_a_carreras();
}
