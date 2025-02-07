<?php
require_once dirname(__FILE__) . '/../meta-box/generador_meta_box.php';

function obtener_informacion_post_type_carreras()
{
    $carreras = new TipoDePost();
    $carreras->set_id('carreras');
    $carreras->set_caracteristicas(array(
        'public' => true,
        'show_ui' => true,
        'labels' => array(
            'name' => __('Carreras'),
            'singular_name' => __('Carrera'),
            'add_new' => __('Agregar nueva'),
            'add_new_item' => __('Agregar nueva carrera'),
            'edit' => __('Editar'),
            'edit_item' => __('Editar carrera'),
            'new_item' => __('Nueva carrera'),
            'view' => __('Ver carrera'),
            'view_item' => __('Ver carrera'),
            'search_items' => __('Buscar'),
            'not_found' => __('No se encontraron carreras'),
            'not_found_in_trash' => __('No se encontraron carreras en la basura'),
            'parent' => __('Carreras'),
        ),
        'menu_icon' => 'dashicons-admin-multisite',
        'menu_position' => 102,
        'show_in_rest' => true, //opcional, sirve para exponerla a la rest api
        'rest_base' => true, // cambia la base del url dela ruta de la rest api 
        'has_archive' => true,
        'show_in_menu' => true,
        'supports' => false,
        'exclude_from_search' => false,
        'capability_type' => $carreras->get_id(),
        'map_meta_cap' => true,
        'capabilities' => [
            'edit_post' => 'edit_carreras',
            'read_post' => 'read_carreras',
            'delete_post' => 'delete_carreras',
            'edit_posts' => 'edit_multiples_carreras',
            'edit_others_posts' => 'edit_others_multiples_carreras',
            'publish_posts' => 'publish_multiples_carreras',
            'read_private_posts' => 'read_private_multiples_carreras',
            'delete_posts' => 'delete_multiples_carreras',
            'delete_private_posts' => 'delete_private_multiples_carreras',
            'delete_published_posts' => 'delete_published_multiples_carreras',
            'delete_others_posts' => 'delete_others_multiples_carreras',
            'edit_private_posts' => 'edit_private_multiples_carreras',
            'edit_published_posts' => 'edit_published_multiples_carreras',
            'create_posts' => 'create_multiples_carreras',
        ],
    ));

    $meta = new TipoMetaBox();
    $meta->asignar_valores_tipo_texto('carreras', 'Editor de carreras', 'test', 'test etiqueta', 'test texto ejemplo', 'test descripcion');
    $meta->crear_tipo_meta_box();

    return $carreras;
}
