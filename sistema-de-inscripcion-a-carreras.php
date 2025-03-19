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
    if (!class_exists('SistemaDeInscripcionACarreras')) {
        require_once dirname(__FILE__) . '/enque.php';
        require_once dirname(__FILE__) . '/activar.php';
        require_once dirname(__FILE__) . '/desactivar.php';
        require_once dirname(__FILE__) . '/desinstalar.php';

        class SistemaDeInscripcionACarreras
        {
            public function __construct()
            {
                register_activation_hook(__FILE__, array($this, 'instalar_plugins_requeridos'));

                add_action('init', 'activar_plugin', -10); // register_activation_hook no funciona

                register_deactivation_hook(__FILE__, 'desactivar_plugin');

                register_uninstall_hook(__FILE__, 'desinstalar_plugin');

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
            }

            public function instalar_plugins_requeridos()
            {
                require_once ABSPATH . 'wp-admin/includes/plugin.php';
                require_once ABSPATH . 'wp-admin/includes/file.php';
                require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
                require_once ABSPATH . 'wp-admin/includes/plugin-install.php';

                $plugins = array(
                    'wp-mail-smtp' => array(
                        'slug' => 'wp-mail-smtp',
                        'file' => 'wp-mail-smtp/wp_mail_smtp.php',
                        'name' => 'WP Mail SMTP'
                    ),
                    // 'wpforms-lite' => array(
                    //     'slug' => 'wpforms-lite',
                    //     'file' => 'wpforms-lite/wpforms.php',
                    //     'name' => 'WPForms Lite'
                    // ),
                    'wp-mail-logging' => array(
                        'slug' => 'wp-mail-logging',
                        'file' => 'wp-mail-logging/wp-mail-logging.php',
                        'name' => 'WP Mail Logging'
                    )
                );

                $errors = array();

                foreach ($plugins as $plugin) {
                    if (!is_plugin_active($plugin['file'])) {

                        // Verificar instalación
                        if (!file_exists(WP_PLUGIN_DIR . '/' . $plugin['file'])) {

                            $upgrader = new Plugin_Upgrader(new Automatic_Upgrader_Skin());
                            $result = $upgrader->install("https://downloads.wordpress.org/plugin/{$plugin['slug']}.latest-stable.zip");

                            if (is_wp_error($result)) {
                                $errors[] = "Error instalando {$plugin['name']}: " . $result->get_error_message();
                                continue;
                            }
                        }

                        // Activar plugin
                        $activation = activate_plugin($plugin['file']);

                        if (is_wp_error($activation)) {
                            $errors[] = "Error activando {$plugin['name']}: " . $activation->get_error_message();
                        }
                    }
                }

                if (!empty($errors)) {
                    set_transient('sistema_inscripcion_errors', $errors, 45);
                }

                // Registrar todas las CPTs y taxonomías
                flush_rewrite_rules();
            }
        }
    }
    new SistemaDeInscripcionACarreras();
}
