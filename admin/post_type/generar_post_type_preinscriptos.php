<?php
function obtener_informacion_post_type_preinscriptos()
{
    $preinscriptos = new TipoDePost();
    $preinscriptos->set_id('preinscriptos');
    $preinscriptos->set_caracteristicas(array(
        'public' => true,
        'show_ui' => true,
        'labels' => array(
            'name' => __('Preinscriptos'),
            'singular_name' => __('Preinscripto'),
            'add_new' => __('Agregar nueva'),
            'add_new_item' => __('Agregar nuevo preinscripto'),
            'edit' => __('Editar'),
            'edit_item' => __('Editar preinscripto'),
            'new_item' => __('Nueva preinscripto'),
            'view' => __('Ver preinscripto'),
            'view_item' => __('Ver preinscripto'),
            'search_items' => __('Buscar'),
            'not_found' => __('No se encontraron preinscriptos'),
            'not_found_in_trash' => __('No se encontraron preinscriptos en la basura'),
            'parent' => __('Preinscriptos'),
        ),
        'menu_icon' => 'dashicons-id-alt',
        'menu_position' => 104,
        'show_in_rest' => true, //opcional, sirve para exponerla a la rest api
        'rest_base' => true, // cambia la base del url dela ruta de la rest api 
        'has_archive' => true,
        'show_in_menu' => true,
        'supports' => false,
        'exclude_from_search' => true,
        'capability_type' => $preinscriptos->get_id(),
        'map_meta_cap' => true,
        'capabilities' => [
            'edit_post' => 'edit_preinscriptos',
            'read_post' => 'read_preinscriptos',
            'delete_post' => 'delete_preinscriptos',
            'edit_posts' => 'edit_multiples_preinscriptos',
            'edit_others_posts' => 'edit_others_multiples_preinscriptos',
            'publish_posts' => 'publish_multiples_preinscriptos',
            'read_private_posts' => 'read_private_multiples_preinscriptos',
            'delete_posts' => 'delete_multiples_preinscriptos',
            'delete_private_posts' => 'delete_private_multiples_preinscriptos',
            'delete_published_posts' => 'delete_published_multiples_preinscriptos',
            'delete_others_posts' => 'delete_others_multiples_preinscriptos',
            'edit_private_posts' => 'edit_private_multiples_preinscriptos',
            'edit_published_posts' => 'edit_published_multiples_preinscriptos',
            'create_posts' => 'create_multiples_preinscriptos',
        ]
    ));
    return $preinscriptos;
}