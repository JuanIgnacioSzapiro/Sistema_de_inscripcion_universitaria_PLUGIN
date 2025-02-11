<?php
require_once dirname(__FILE__) . '/../meta-box/generador_meta_box.php';
require_once dirname(__FILE__) . '/../meta-box/meta_box_tipo_texto.php';
require_once dirname(__FILE__) . '/../meta-box/meta_box_tipo_texto_clonable.php';

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
            //new MetaBoxTipoTexto( //(DEBE SER MODIFICADO A TIPO SELECCIONADOR DE UN TYPE_POST)
            //     'plan_de_estudios_y_programas_de_la_carrera',
            //     'Plan de estudios y Programas de la carrera ',
            //     '',
            //     'Se selecciona un plan de estudio, previamente creado y publicado'
            // ),
            // new MetaBoxTipoTexto( // (DEBE SE TIPO ARCHIVO)
            //     'correlatividades_del_acarrera',
            //     'Correlatividades del acarrera', '',
            //     ''
            // ),
            // new MetaBoxTipoTexto( // (DEBE SE TIPO ARCHIVO)
            //     'horarios_turno_manana_de_la_carrera',
            //     'Horarios Turno Mañana de la carrera', '',
            //     ''
            // ),
            // new MetaBoxTipoTexto( // (DEBE SE TIPO ARCHIVO)
            //     'horarios_turno_tarde_de_la_carrera',
            //     'Horarios Turno Tarde de la carrera', '',
            //     ''
            // ),
            // new MetaBoxTipoTexto( // (DEBE SE TIPO ARCHIVO)
            //     'horarios_turno_noche_de_la_carrera',
            //     'Horarios Turno Noche de la carrera', '',
            //     ''
            // ),
            // new MetaBoxTipoTexto( // (DEBE SE TIPO ARCHIVO)
            //     'mesas_de_examen_turno_manana_de_la_carrera',
            //     'Mesas de examen turno mañana de la carrera', '',
            //     ''
            // ),
            // new MetaBoxTipoTexto( // (DEBE SE TIPO ARCHIVO)
            //     'mesas_de_examen_turno_tarde_de_la_carrera',
            //     'Mesas de examen turno tarde de la carrera', '',
            //     ''
            // ),
            // new MetaBoxTipoTexto( // (DEBE SE TIPO ARCHIVO)
            //     'mesas_de_examen_turno_noche_de_la_carrera',
            //     'Mesas de examen turno noche de la carrera', '',
            //     ''
            // ),
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
