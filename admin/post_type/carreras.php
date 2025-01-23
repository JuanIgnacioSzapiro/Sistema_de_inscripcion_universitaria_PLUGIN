<?php
require_once(dirname(__FILE__) . "/generador_post_type.php");

function registrar_carreras()
{
    registrar_post_type('carreras', array(
        'public' => true,
        'label' => 'Carreras',
        'menu_icon' => 'dashicons-database',
    ));
}

add_action('init', 'registrar_carreras');

function deregistrar_carreras()
{
    deregistrar_post_type('carreras');
}