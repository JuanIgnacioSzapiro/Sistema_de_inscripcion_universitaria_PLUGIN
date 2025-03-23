<?php
function activar_paginas()
{
    $title_of_the_page = array(
        'Demostración shortcodes' => "[mostrar_galeria post_type='carreras']",
        'Documentación para la inscripción a carreras 2025' => "[doc_insc_2025]",
        'Pre formulario de pre inscripción 2025' => "[pre_formulario_preinscriptos]",
    );

    foreach ($title_of_the_page as $key => $item) {
        $objPage = new_get_page_by_title($key, 'OBJECT', 'page');
        if (empty($objPage)) {
            create_page($key, $item);
        }
    }
}

function create_page($title_of_the_page, $content, $parent_id = NULL)
{
    $page_id = wp_insert_post(
        array(
            'comment_status' => 'close',
            'ping_status' => 'close',
            'post_author' => 1,
            'post_title' => $title_of_the_page,
            'post_name' => strtolower(str_replace(' ', '_', trim($title_of_the_page))),
            'post_status' => 'publish',
            'post_content' => $content,
            'post_type' => 'page',
            'post_parent' => $parent_id //'id_of_the_parent_page_if_it_available'
        )
    );
    return $page_id;
}

function new_get_page_by_title( $page_title, $output = OBJECT, $post_type = 'page' ) {
    $args  = array(
        'title'                  => $page_title,
        'post_type'              => $post_type,
        'post_status'            => get_post_stati(),
        'posts_per_page'         => 1,
        'update_post_term_cache' => false,
        'update_post_meta_cache' => false,
        'no_found_rows'          => true,
        'orderby'                => 'post_date ID',
        'order'                  => 'ASC',
    );
    $query = new WP_Query( $args );
    $pages = $query->posts;

    if ( empty( $pages ) ) {
        return null;
    }

    return get_post( $pages[0], $output );
}
