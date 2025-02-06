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

    return $carreras;
}

add_filter('rwmb_meta_boxes', 'your_prefix_register_meta_boxes');

function your_prefix_register_meta_boxes($meta_boxes)
{
    $prefix = 'INSPT_SISTEMA_DE_INSCRIPCION_A_CARRERAS_CARRERAS_';

    $meta_boxes[] = [
        'title' => esc_html__('Carrera Details', 'textdomain'),
        'id' => 'carreras-details',
        'post_types' => ['carreras'],
        'context' => 'normal',
        'priority' => 'high',
        'fields' => [
            [
                'type' => 'text',
                'name' => esc_html__('Número de plan de la carrera', 'online-generator'),
                'id' => $prefix . 'numero_de_plan_de_la_carrera',
                'desc' => esc_html__('Se ingresa el nro. del plan de la carrera', 'online-generator'),
                'placeholder' => esc_html__('60', 'online-generator'),
            ],
            [
                'type' => 'text',
                'name' => esc_html__('Nombre de la carrera', 'online-generator'),
                'id' => $prefix . 'nombre_de_la_carrera',
                'desc' => esc_html__('Se ingresa el nombre completo de la carrera', 'online-generator'),
                'placeholder' => esc_html__('Tecnicatura Superior en Informática Aplicada', 'online-generator'),
            ],
            [
                'type' => 'text',
                'name' => esc_html__('Descripción corta de la carrera', 'online-generator'),
                'id' => $prefix . 'descripcion_corta_de_la_carrera',
                'desc' => esc_html__('Se ingresa una descripción de la carrera que aparece en la galería de carreras', 'online-generator'),
                'placeholder' => esc_html__('Tecnicatura Superior + un año de formación Docente', 'online-generator'),
            ],
            [
                'type' => 'textarea',
                'name' => esc_html__('Descripción de la carrera', 'online-generator'),
                'id' => $prefix . 'descripcion_de_la_carrera',
                'desc' => esc_html__('Se ingresa una descripción de la carrera', 'online-generator'),
                'placeholder' => esc_html__('El/la Técnico/a Superior en Informática Aplicada tendrá como área de acción principal la problemática de la construcción de software, que se corresponde con las tareas tradicionalmente conocidas como análisis, diseño y programación (...)', 'online-generator'),
            ],
            [
                'type' => 'textarea',
                'name' => esc_html__('Profesional en condiciones de la carrera', 'online-generator'),
                'id' => $prefix . 'profesional_en_condiciones_de_la_carrera',
                'desc' => esc_html__('Se ingresa una por cada ítem en su respectiva casilla, de ser necesario se generan más', 'online-generator'),
                'placeholder' => esc_html__('Realizar el análisis y especificación formal, diseño, codificación, implementación, prueba, verificación, documentación, mantenimiento y control de calidad de sistemas de software que se ejecuten sobre sistemas de procesamiento de datos.', 'online-generator'),
                'clone' => true,
            ],
            [
                'type' => 'url',
                'name' => esc_html__('Resolución ministerial de la carrera', 'online-generator'),
                'id' => $prefix . 'resolucion_ministerial_de_la_carrera',
                'desc' => esc_html__('Link de la resolución ministerial', 'online-generator'),
                'placeholder' => esc_html__('https://inspt.utn.edu.ar/este-es-un-ejemplo.pdf', 'online-generator'),
            ],
            [
                'type' => 'post',
                'name' => esc_html__('Plan de estudios y Programas de la carrera', 'online-generator'),
                'id' => $prefix . 'plan_de_estudios_y_programas_de_la_carrera',
                'desc' => esc_html__('Se selecciona un plan de estudio, previamente creado y publicado', 'online-generator'),
                'post_type' => 'plan_de_estudios_y_programas',
                'field_type' => 'select_advanced', // Dropdown with search
                'placeholder' => 'Planes de estudio y programas',
                'parent' => true, // Allow hierarchical posts (if applicable)
            ],
            [
                'type' => 'file_advanced',
                'name' => esc_html__('Correlatividades del acarrera', 'online-generator'),
                'id' => $prefix . 'correlatividades_del_acarrera',
                'force_delete' => false,
                'max_file_uploads' => 1,
                'mime_type' => 'application/pdf',
                'desc' => esc_html__('Seleccionar archivos .pdf', 'online-generator'),
            ],
            [
                'type' => 'file_advanced',
                'name' => esc_html__('Horarios Turno Mañana de la carrera', 'online-generator'),
                'id' => $prefix . 'horarios_turno_manana_de_la_carrera',
                'force_delete' => false,
                'max_file_uploads' => 1,
                'mime_type' => 'application/pdf',
                'desc' => esc_html__('Seleccionar archivos .pdf', 'online-generator'),
            ],
            [
                'type' => 'file_advanced',
                'name' => esc_html__('Horarios Turno Tarde de la carrera', 'online-generator'),
                'id' => $prefix . 'horarios_turno_tarde_de_la_carrera',
                'force_delete' => false,
                'max_file_uploads' => 1,
                'mime_type' => 'application/pdf',
                'desc' => esc_html__('Seleccionar archivos .pdf', 'online-generator'),
            ],
            [
                'type' => 'file_advanced',
                'name' => esc_html__('Horarios Turno Noche de la carrera', 'online-generator'),
                'id' => $prefix . 'horarios_turno_noche_de_la_carrera',
                'force_delete' => false,
                'max_file_uploads' => 1,
                'mime_type' => 'application/pdf',
                'desc' => esc_html__('Seleccionar archivos .pdf', 'online-generator'),
            ],
            [
                'type' => 'file_advanced',
                'name' => esc_html__('Mesas de examen turno mañana de la carrera', 'online-generator'),
                'id' => $prefix . 'mesas_de_examen_turno_manana_de_la_carrera',
                'force_delete' => false,
                'max_file_uploads' => 1,
                'mime_type' => 'application/pdf',
                'desc' => esc_html__('Seleccionar archivos .pdf', 'online-generator'),
            ],
            [
                'type' => 'file_advanced',
                'name' => esc_html__('Mesas de examen turno tarde de la carrera', 'online-generator'),
                'id' => $prefix . 'mesas_de_examen_turno_tarde_de_la_carrera',
                'force_delete' => false,
                'max_file_uploads' => 1,
                'mime_type' => 'application/pdf',
                'desc' => esc_html__('Seleccionar archivos .pdf', 'online-generator'),
            ],
            [
                'type' => 'file_advanced',
                'name' => esc_html__('Mesas de examen noche mañana de la carrera', 'online-generator'),
                'id' => $prefix . 'mesas_de_examen_noche_manana_de_la_carrera',
                'force_delete' => false,
                'max_file_uploads' => 1,
                'mime_type' => 'application/pdf',
                'desc' => esc_html__('Seleccionar archivos .pdf', 'online-generator'),
            ],
            [
                'type' => 'text',
                'name' => esc_html__('Nombre de la dirección de la carrera', 'online-generator'),
                'id' => $prefix . 'nombre_de_la_direccion_de_la_carrera',
            ],
            [
                'type' => 'textarea',
                'name' => esc_html__('Descripción de la dirección de la carrera', 'online-generator'),
                'id' => $prefix . 'descripcion_de_la_direccion_de_la_carrera',
            ],
            [
                'type' => 'text',
                'name' => esc_html__('Nombre del referente de laboratorio', 'online-generator'),
                'id' => $prefix . 'nombre_del_referente_de_laboratorio',
            ],
            [
                'type' => 'textarea',
                'name' => esc_html__('Descripción del referente de laboratorio', 'online-generator'),
                'id' => $prefix . 'descripcion_del_referente_de_laboratorio',
            ],
            [
                'type' => 'text',
                'name' => esc_html__('Grado académico', 'online-generator'),
                'id' => $prefix . 'grado_academico',
            ],
            [
                'type' => 'text',
                'name' => esc_html__('Modalidad', 'online-generator'),
                'id' => $prefix . 'modalidad',
            ],
            [
                'type' => 'text',
                'name' => esc_html__('Consultas a', 'online-generator'),
                'id' => $prefix . 'consultas_a',
                'desc' => esc_html__('Se ingresa un métodode contácto por cada casilla, de ser necesario se generan más', 'online-generator'),
                'clone' => true,
            ],
        ],
    ];

    return $meta_boxes;
}

add_action('save_post', 'update_carrera_post_title', 10, 2);

function update_carrera_post_title($post_id, $post)
{
    $prefix = 'INSPT_SISTEMA_DE_INSCRIPCION_A_CARRERAS_CARRERAS_';

    // Check if the post type is 'carreras'
    if ($post->post_type !== 'carreras') {
        return;
    }

    // Check if this is not an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check if the user has permissions to save the post
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Get the value of the 'nombre_de_la_carrera' meta field
    $nombre_de_la_carrera = get_post_meta($post_id, $prefix . 'nombre_de_la_carrera', true);

    // If the meta field is not empty, update the post title
    if (!empty($nombre_de_la_carrera)) {
        // Unhook this function to prevent infinite loop
        remove_action('save_post', 'update_carrera_post_title', 10);

        // Update the post title
        wp_update_post(array(
            'ID' => $post_id,
            'post_title' => $nombre_de_la_carrera,
        ));

        // Re-hook this function
        add_action('save_post', 'update_carrera_post_title', 10, 2);
    }
}