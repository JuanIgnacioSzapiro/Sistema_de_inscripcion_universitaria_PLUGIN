<?php
function obtener_el_link_de_pagina($key_de_array_asociado)
{
    return get_post(get_post_meta(get_posts(
        array(
            'numberposts' => 1,
            'post_type' => 'links_preinscriptos',
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'ASC'
        )
    )[0]->ID, $key_de_array_asociado, true))->guid;
}

function obtener_resultado_query($query)
{
    global $wpdb;

    // Es buena práctica usar prepare() para evitar inyecciones SQL
    return $wpdb->get_results($query);
}

function espiar($texto, $data)
{
    error_log($texto . ': ' . print_r($data, true));
    return $data;
}