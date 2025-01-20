<?php

if (!function_exists("agregar_js")) {
    function agregar_js()
    {
        wp_register_script('sistema_de_inscripcion_a_carreras_js', plugins_url('public/js/general.js', __FILE__), array('jquery'), '1', true); //los scripts se ponen en el footer (por eso el ultimo valor es true)
        wp_enqueue_script('sistema_de_inscripcion_a_carreras_js');
    }

    add_action('wp_enqueue_scripts', 'agregar_js');
}
