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
function my_plugin_install_dependencies()
{
    // Check if Meta Box is already active
    if (!is_plugin_active('meta-box/meta-box.php')) {
        // Include necessary WordPress files
        require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/misc.php';
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
        require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

        // Plugin slug and ZIP URL
        $plugin_slug = 'meta-box';
        $plugin_zip_url = 'https://downloads.wordpress.org/plugin/meta-box.latest-stable.zip';

        // Install the plugin
        $upgrader = new Plugin_Upgrader(new Automatic_Upgrader_Skin());
        $installed = $upgrader->install($plugin_zip_url);

        if ($installed) {
            // Activate the plugin
            activate_plugin($plugin_slug . '/' . $plugin_slug . '.php');
        }
    }
}
register_activation_hook(__FILE__, 'my_plugin_install_dependencies');

if (!defined('ABSPATH')) { // si la busqueda de la página web no es del path absoluto que le da por default wordpress...
    die('Acceso no permitido');
} else {
    if (!class_exists('SistemaDeInscripcionACarreras')) {
        require_once dirname(__FILE__) . '/enque.php';
        require_once dirname(__FILE__) . '/activar.php';
        require_once dirname(__FILE__) . '/desactivar.php';
        require_once dirname(__FILE__) . '/desinstalar.php';

        class SistemaDeInscripcionACarreras
        {
            public function __construct()
            {
                add_action('init', 'activar_plugin', -10); // register_activation_hook no funciona

                register_deactivation_hook(__FILE__, 'desactivar_plugin');

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
    new SistemaDeInscripcionACarreras();
}
