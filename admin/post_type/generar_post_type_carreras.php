<?php // generar_post_type_carreras.php
require_once dirname(__FILE__) . '/meta-box/generador_meta_box.php';
require_once dirname(__FILE__) . '/meta-box/meta_box_tipo_archivo.php';
require_once dirname(__FILE__) . '/meta-box/meta_box_tipo_drop_down_post.php';
require_once dirname(__FILE__) . '/meta-box/meta_box_tipo_texto.php';
require_once dirname(__FILE__) . '/meta-box/meta_box_tipo_texto_clonable.php';
require_once dirname(__FILE__) . '/filtros/creador_filtros.php';
require_once dirname(__FILE__) . '/filtros/filro.php';


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
    $meta = new TipoMetaBox(
        'carreras',
        'Editor de carreras',
        array(
            new MetaBoxTipoTexto(
                'numero_de_plan_de_la_carrera',
                'Número de plan de la carrera',
                '60',
                'Se ingresa el número del plan de la carrera'
            ),
            new MetaBoxTipoTexto(
                'nombre_de_la_carrera',
                'Nombre de la carrera',
                'Tecnicatura Superior en Informática Aplicada',
                'Se ingresa el nombre completo de la carrera'
            ),
            new MetaBoxTipoTexto(
                'descripcion_corta_de_la_carrera',
                'Descripción corta de la carrera',
                'Tecnicatura Superior + un año de formación Docente',
                'Se ingresa una descripción de la carrera que aparece en la galería de carreras'
            ),
            new MetaBoxTipoTexto(
                'descripcion_de_la_carrera',
                'Descripción de la carrera',
                'El/la Técnico/a Superior en Informática Aplicada tendrá como área de acción principal la problemática de la construcción de software, que se corresponde con las tareas tradicionalmente conocidas como análisis, diseño y programación (...)',
                'Se ingresa una descripción de la carrera'
            ),
            new MetaBoxTipoTextoClonable(
                'profesional_en_condiciones_de_la_carrera',
                'Profesional en condiciones de la carrera',
                'Realizar el análisis y especificación formal, diseño, codificación, implementación, prueba, verificación, documentación, mantenimiento y (...)',
                'Se ingresa una por cada ítem en su respectiva casilla, de ser necesario se generan más'
            ),
            new MetaBoxTipoTexto(
                'resolucion_ministerial_de_la_carrera',
                'Resolución ministerial de la carrera',
                'https://inspt.utn.edu.ar/este-es-un-ejemplo.pdf',
                'Link de la resolución ministerial'
            ),
            new MetaBoxTipoDopDownPostType(
                'plan_de_estudios_y_programas_de_la_carrera',
                'Plan de estudios y Programas de la carrera ',
                'plan_de_estudios_y_programas_de_la_carrera',
                'Se selecciona un plan de estudio, previamente creado y publicado'
            ),
            new TipoMetaBoxArchivo(
                'correlatividades_del_acarrera',
                'Correlatividades del acarrera',
                'application/pdf',
                'Subir archivo .pdf'
            ),
            new TipoMetaBoxArchivo(
                'horarios_turno_manana_de_la_carrera',
                'Horarios Turno Mañana de la carrera',
                'application/pdf',
                'Subir archivo .pdf'
            ),
            new TipoMetaBoxArchivo(
                'horarios_turno_tarde_de_la_carrera',
                'Horarios Turno Tarde de la carrera',
                'application/pdf',
                'Subir archivo .pdf'
            ),
            new TipoMetaBoxArchivo(
                'horarios_turno_noche_de_la_carrera',
                'Horarios Turno Noche de la carrera',
                'application/pdf',
                'Subir archivo .pdf'
            ),
            new TipoMetaBoxArchivo(
                'mesas_de_examen_turno_manana_de_la_carrera',
                'Mesas de examen turno mañana de la carrera',
                'application/pdf',
                'Subir archivo .pdf'
            ),
            new TipoMetaBoxArchivo(
                'mesas_de_examen_turno_tarde_de_la_carrera',
                'Mesas de examen turno tarde de la carrera',
                'application/pdf',
                'Subir archivo .pdf'
            ),
            new TipoMetaBoxArchivo(
                'mesas_de_examen_turno_noche_de_la_carrera',
                'Mesas de examen turno noche de la carrera',
                'application/pdf',
                'Subir archivo .pdf'
            ),
            new MetaBoxTipoTexto(
                'nombre_de_la_direccion_de_la_carrera',
                'Nombre de la dirección de la carrera',
                'Dra. Paula Ithurralde',
                ''
            ),
            new MetaBoxTipoTexto(
                'descripcion_de_la_direccion_de_la_carrera',
                'Descripción de la dirección de la carrera',
                'Paula Ithurralde es técnica en administración y gestión universitaria, titulación otorgada (...)',
                ''
            ),
            new MetaBoxTipoTexto(
                'nombre_del_referente_de_laboratorio',
                'Nombre del referente de laboratorio',
                'Prof. Matías Garcia',
                ''
            ),
            new MetaBoxTipoTexto(
                'descripcion_del_referente_de_laboratorio',
                'Descripción del referente de laboratorio',
                'Profesor y Técnico en Informática Aplicada, egresado del Instituto Nacional Superior del (...)',
                ''
            ),
            new MetaBoxTipoTexto(
                'grado_academico',
                'Grado académico',
                'Pregado',
                ''
            ),
            new MetaBoxTipoTexto(
                'modalidad',
                'Modalidad',
                'Presencial',
                ''
            ),
            new MetaBoxTipoTextoClonable(
                'consultas_a',
                'Consultas a',
                'info@inspt.utn.edu.ar',
                'Se ingresa un métodode contácto por cada casilla, de ser necesario se generan más'
            ),
        )
    );

    $meta->crear_tipo_meta_box();

    return $carreras;
}

// Register sortable columns
add_filter('manage_edit-carreras_sortable_columns', 'mis_columnas_sortables');

function mis_columnas_sortables($columns)
{
    $columns['numero_de_plan_de_la_carrera'] = 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_numero_de_plan_de_la_carrera';
    $columns['nombre_de_la_carrera'] = 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_nombre_de_la_carrera';
    $columns['creador'] = 'author';
    $columns['fecha_de_carga'] = 'date';
    $columns['modificador'] = 'Último modificador';
    $columns['fecha_de_modificacion'] = 'modified';
    return $columns;
}

// Handle custom sorting
add_action('pre_get_posts', 'manejar_ordenamiento_columnas');

function manejar_ordenamiento_columnas($query)
{
    if (!is_admin() || !$query->is_main_query() || 'carreras' !== $query->get('post_type')) {
        return;
    }

    $orderby = $query->get('orderby');

    switch ($orderby) {
        case 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_numero_de_plan_de_la_carrera':
            $query->set('meta_key', 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_numero_de_plan_de_la_carrera');
            $query->set('orderby', 'meta_value_num'); // Use numeric sorting for numbers
            break;
        case 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_nombre_de_la_carrera':
            $query->set('meta_key', 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_nombre_de_la_carrera');
            $query->set('orderby', 'meta_value'); // Use alphabetical sorting for text
            break;
        case 'modificador':
            $query->get_results($query->prepare("SELECT * FROM wp_postmeta ORDER BY meta_id"));
            break;
    }
}


add_filter('manage_carreras_posts_columns', 'mis_columnas');

function mis_columnas($columnas)
{
    $columnas = array(
        'cb' => $columnas['cb'],
        'numero_de_plan_de_la_carrera' => ' Número de plan de la carrera ',
        'nombre_de_la_carrera' => 'Nombre de la carrera',
        'creador' => 'Creador',
        'fecha_de_carga' => 'Fecha de carga',
        'modificador' => 'Último modificador',
        'fecha_de_modificacion' => 'Fecha de modificación',
    );
    return $columnas;
}

add_action('manage_carreras_posts_custom_column', 'cargar_mis_columnas', 10, 2);

function cargar_mis_columnas($columnas, $post_id)
{
    switch ($columnas) {
        case 'numero_de_plan_de_la_carrera':
            echo esc_html(get_post_meta($post_id, 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_numero_de_plan_de_la_carrera', true));
            break;
    }
    switch ($columnas) {
        case 'nombre_de_la_carrera':
            echo esc_html(get_post_meta($post_id, 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_nombre_de_la_carrera', true));
            break;
    }
    switch ($columnas) {
        case 'creador':
            echo esc_html(get_the_author($post_id));
            break;
    }
    switch ($columnas) {
        case 'fecha_de_carga':
            echo esc_html(get_the_modified_date("", $post_id));
            break;
    }
    switch ($columnas) {
        case 'modificador':
            echo esc_html(get_the_author($post_id));
            break;
    }
    switch ($columnas) {
        case 'fecha_de_modificacion':
            echo esc_html(get_the_modified_date("", $post_id));
            break;
    }
}


$filtrosXcreador = new CreadorFiltros('carreras', array(
    new Filtro('filtroXcreador', "SELECT ID FROM wp_users WHERE user_login LIKE %s", 'author__in', 'Filtrar por creador'),
    new Filtro('filtro_x_nombre_o_numero_de_carrera', "SELECT DISTINCT wp_postmeta.post_id FROM wp_postmeta INNER JOIN wp_posts ON wp_postmeta.post_id = wp_posts.ID WHERE ( (wp_postmeta.meta_key = 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_numero_de_plan_de_la_carrera' AND wp_postmeta.meta_value LIKE %s) OR  (wp_postmeta.meta_key = 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_nombre_de_la_carrera' AND wp_postmeta.meta_value LIKE %s))", 'post__in', 'Filtrar por número de plan o nombre de la carrera')
));

