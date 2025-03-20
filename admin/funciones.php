<?php
function obtener_el_link_documentacion()
{
    return get_post(get_post_meta(get_posts(
        array(
            'numberposts' => 1,
            'post_type' => 'links_preinscriptos',
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'ASC'
        )
    )[0]->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_links_preinscriptos_link_documentacion')[0])->guid;
}
function obtener_el_link_formulario()
{
    return get_post(get_post_meta(get_posts(
        array(
            'numberposts' => 1,
            'post_type' => 'links_preinscriptos',
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'ASC'
        )
    )[0]->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_links_preinscriptos_link_preinscripcion')[0])->guid;
}
function obtener_el_link_previo_preinscripcion()
{
    return get_post(get_post_meta(get_posts(
        array(
            'numberposts' => 1,
            'post_type' => 'links_preinscriptos',
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'ASC'
        )
    )[0]->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_links_preinscriptos_link_previo_preinscripcion')[0])->guid;
}