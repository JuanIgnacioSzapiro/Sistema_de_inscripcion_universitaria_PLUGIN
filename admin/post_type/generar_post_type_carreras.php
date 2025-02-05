<?php

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

    add_action('add_meta_boxes', 'crear_metadata');

    return $carreras;
}

function crear_metadata()
{
    add_meta_box('meta_personalizada_carreras', 'Carreras', 'mostrar_meta_carreras', 'carreras');
}

function mostrar_meta_carreras($post)
{
    // Retrieve existing meta data
    $custom_field_value = get_post_meta($post->ID, '_custom_meta_key', true);

    // Add a nonce field for security
    wp_nonce_field('custom_meta_box_nonce', 'custom_meta_box_nonce');

    // Output the HTML for the meta box
    ?>
    <label for="custom_field">Custom Field:</label>
    <input type="text" id="custom_field" name="custom_field" value="<?php echo $custom_field_value ?>" style="width: 100%;" />
    <?php
}

function save_custom_meta_box_data($post_id)
{
    // Check if nonce is set and valid
    if (!isset($_POST['custom_meta_box_nonce']) || !wp_verify_nonce($_POST['custom_meta_box_nonce'], 'custom_meta_box_nonce')) {
        return;
    }

    // Check if the current user has permission to edit the post
    if (!current_user_can('edit_carreras', $post_id)) {
        return;
    }

    // Save the custom field data
    if (isset($_POST['custom_field'])) {
        update_post_meta(
            $post_id,
            '_custom_meta_key', // Meta key
            sanitize_text_field($_POST['custom_field']) // Sanitized value
        );
    }
}
add_action('save_post', 'save_custom_meta_box_data');