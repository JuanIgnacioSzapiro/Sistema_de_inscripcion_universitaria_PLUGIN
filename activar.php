<?php
require_once dirname(__FILE__) . '/admin/activaciones/activador_post_types.php';
require_once dirname(__FILE__) . '/admin/activaciones/activador_roles.php';

function activar_plugin()
{
    add_action('wp_enqueue_scripts', 'agregar_js');

    activar_post_types();

    activar_roles();

    flush_rewrite_rules(); // limpia permalinks
}