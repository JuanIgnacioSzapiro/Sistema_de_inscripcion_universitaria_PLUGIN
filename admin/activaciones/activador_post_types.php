<?php //activador_post_types.php
require_once dirname(__FILE__) . '/../post_type/generador_post_type.php';
<<<<<<< HEAD
require_once dirname(__FILE__) . '/../post_type/mis_post_type/generar_post_type_general.php';
require_once dirname(__FILE__) . '/../post_type/meta-box/meta_box_drop_down_predeterminado.php';
=======
require_once dirname(__FILE__) . '/../post_type/mis_post_type/generar_post_type_carreras.php';
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e


function activar_post_types()
{
    $carreras = new CreadorTipoDePost(
        'carrera',
        'carreras',
        true,
        'INSPT_SISTEMA_DE_INSCRIPCIONES',
        'dashicons-bank',
        new TipoMetaBox(
            'Editor de carreras',
            array(
<<<<<<< HEAD
                new CampoTexto(
=======
                new MetaBoxTipoTexto(
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
                    'numero_de_plan_de_la_carrera',
                    'Número de plan de la carrera',
                    '60',
                    'Se ingresa el número del plan de la carrera'
                ),
<<<<<<< HEAD
                new CampoTexto(
=======
                new MetaBoxTipoTexto(
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
                    'nombre_de_la_carrera',
                    'Nombre de la carrera',
                    'Tecnicatura Superior en Informática Aplicada',
                    'Se ingresa el nombre completo de la carrera'
                ),
<<<<<<< HEAD
                new CampoDropDownTipoPost(
                    'tipo_de_carrera',
                    'Tipo de carrera',
                    'tipos_de_carrera',
                    'Se selecciona el tipo de carrera'
                ),
                new CampoTexto(
=======
                new MetaBoxTipoDropDownPostType(
                    'tipo_de_carrera',
                    'Tipo de carrera',
                    'tipo_de_carrera',
                    'Se selecciona el tipo de carrera'
                ),
                new MetaBoxTipoTexto(
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
                    'descripcion_corta_de_la_carrera',
                    'Descripción corta de la carrera',
                    'Tecnicatura Superior + un año de formación Docente',
                    'Se ingresa una descripción de la carrera que aparece en la galería de carreras'
                ),
<<<<<<< HEAD
                new CampoTexto(
=======
                new MetaBoxTipoTexto(
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
                    'descripcion_de_la_carrera',
                    'Descripción de la carrera',
                    'El/la Técnico/a Superior en Informática Aplicada tendrá como área de acción principal la problemática de la construcción de software, que se corresponde con las tareas tradicionalmente conocidas como análisis, diseño y programación (...)',
                    'Se ingresa una descripción de la carrera'
                ),
<<<<<<< HEAD
                new CampoTexto(
                    'profesional_en_condiciones_de_la_carrera',
                    'Profesional en condiciones de la carrera',
                    'Realizar el análisis y especificación formal, diseño, codificación, implementación, prueba, verificación, documentación, mantenimiento y (...)',
                    'Se ingresa una por cada ítem en su respectiva casilla, de ser necesario se generan más',
                    true
                ),
                new CampoTexto(
=======
                new MetaBoxTipoTextoClonable(
                    'profesional_en_condiciones_de_la_carrera',
                    'Profesional en condiciones de la carrera',
                    'Realizar el análisis y especificación formal, diseño, codificación, implementación, prueba, verificación, documentación, mantenimiento y (...)',
                    'Se ingresa una por cada ítem en su respectiva casilla, de ser necesario se generan más'
                ),
                new MetaBoxTipoTexto(
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
                    'resolucion_ministerial_de_la_carrera',
                    'Resolución ministerial de la carrera',
                    'https://inspt.utn.edu.ar/este-es-un-ejemplo.pdf',
                    'Link de la resolución ministerial'
                ),
<<<<<<< HEAD
                new CampoDropDownTipoPost(
                    'plan_de_estudios_y_programas_de_la_carrera',
                    'Plan de estudios y Programas de la carrera ',
                    'materias',
                    'Se selecciona un plan de estudio, previamente creado y publicado'
                ),
                new CampoArchivo(
=======
                new MetaBoxTipoDropDownPostType(
                    'plan_de_estudios_y_programas_de_la_carrera',
                    'Plan de estudios y Programas de la carrera ',
                    'plan_de_estudios_y_programas_de_la_carrera',
                    'Se selecciona un plan de estudio, previamente creado y publicado'
                ),
                new TipoMetaBoxArchivo(
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
                    'correlatividades_del_acarrera',
                    'Correlatividades del acarrera',
                    'application/pdf',
                    'Subir archivo .pdf'
                ),
<<<<<<< HEAD
                new CampoArchivo(
=======
                new TipoMetaBoxArchivo(
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
                    'horarios_turno_manana_de_la_carrera',
                    'Horarios Turno Mañana de la carrera',
                    'application/pdf',
                    'Subir archivo .pdf'
                ),
<<<<<<< HEAD
                new CampoArchivo(
=======
                new TipoMetaBoxArchivo(
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
                    'horarios_turno_tarde_de_la_carrera',
                    'Horarios Turno Tarde de la carrera',
                    'application/pdf',
                    'Subir archivo .pdf'
                ),
<<<<<<< HEAD
                new CampoArchivo(
=======
                new TipoMetaBoxArchivo(
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
                    'horarios_turno_noche_de_la_carrera',
                    'Horarios Turno Noche de la carrera',
                    'application/pdf',
                    'Subir archivo .pdf'
                ),
<<<<<<< HEAD
                new CampoArchivo(
=======
                new TipoMetaBoxArchivo(
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
                    'mesas_de_examen_turno_manana_de_la_carrera',
                    'Mesas de examen turno mañana de la carrera',
                    'application/pdf',
                    'Subir archivo .pdf'
                ),
<<<<<<< HEAD
                new CampoArchivo(
=======
                new TipoMetaBoxArchivo(
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
                    'mesas_de_examen_turno_tarde_de_la_carrera',
                    'Mesas de examen turno tarde de la carrera',
                    'application/pdf',
                    'Subir archivo .pdf'
                ),
<<<<<<< HEAD
                new CampoArchivo(
=======
                new TipoMetaBoxArchivo(
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
                    'mesas_de_examen_turno_noche_de_la_carrera',
                    'Mesas de examen turno noche de la carrera',
                    'application/pdf',
                    'Subir archivo .pdf'
                ),
<<<<<<< HEAD
                new CampoTexto(
=======
                new MetaBoxTipoTexto(
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
                    'nombre_de_la_direccion_de_la_carrera',
                    'Nombre de la dirección de la carrera',
                    'Dra. Paula Ithurralde',
                    ''
                ),
<<<<<<< HEAD
                new CampoTexto(
=======
                new MetaBoxTipoTexto(
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
                    'descripcion_de_la_direccion_de_la_carrera',
                    'Descripción de la dirección de la carrera',
                    'Paula Ithurralde es técnica en administración y gestión universitaria, titulación otorgada (...)',
                    ''
                ),
<<<<<<< HEAD
                new CampoTexto(
=======
                new MetaBoxTipoTexto(
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
                    'nombre_del_referente_de_laboratorio',
                    'Nombre del referente de laboratorio',
                    'Prof. Matías Garcia',
                    ''
                ),
<<<<<<< HEAD
                new CampoTexto(
=======
                new MetaBoxTipoTexto(
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
                    'descripcion_del_referente_de_laboratorio',
                    'Descripción del referente de laboratorio',
                    'Profesor y Técnico en Informática Aplicada, egresado del Instituto Nacional Superior del (...)',
                    ''
                ),
<<<<<<< HEAD
                new CampoTexto(
=======
                new MetaBoxTipoTexto(
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
                    'grado_academico',
                    'Grado académico',
                    'Pregado',
                    ''
                ),
<<<<<<< HEAD
                new CampoTexto(
=======
                new MetaBoxTipoTexto(
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
                    'modalidad',
                    'Modalidad',
                    'Presencial',
                    ''
                ),
<<<<<<< HEAD
                new CampoTexto(
                    'consultas_a',
                    'Consultas a',
                    'info@inspt.utn.edu.ar',
                    'Se ingresa un métodode contácto por cada casilla, de ser necesario se generan más',
                    true
                ),
            ),
            'nombre_de_la_carrera'
        ),
        array('numero_de_plan_de_la_carrera', 'nombre_de_la_carrera', ),
    );
    $tipo_de_carrera = new CreadorTipoDePost(
        'tipo_de_carrera',
        'tipos_de_carrera',
        true,
        'INSPT_SISTEMA_DE_INSCRIPCIONES',
        'dashicons-bank',
        new TipoMetaBox(
            'Editor de tipos de carrera',
            array(
                new CampoTexto(
                    'nombre_tipo_de_carrera',
                    'Nombre tipo del tipo de carrera',
                    'Profesorado',
                    'Se ingresa el nombre del tipo de la carrera'
                ),
            ),
            'nombre_tipo_de_carrera',
        ),
        array('nombre_tipo_de_carrera'),
    );
    $materias = new CreadorTipoDePost(
        'materia',
        'materias',
        true,
        'INSPT_SISTEMA_DE_INSCRIPCIONES',
        'dashicons-bank',
        new TipoMetaBox(
            'Editor de materias',
            array(
                new CampoTexto(
                    'codigo_de_materia',
                    'Código de la materia',
                    '60101',
                    'Se ingresa el código de la materia'
                ),
                new CampoTexto(
                    'asginatura',
                    'Asignatura',
                    'Análisis Matemático I',
                    'Se ingresa el código de la asginatura'
                ),
                new CampoDropDownPredeterminado(
                    'tipo_de_cursada',
                    'Tipo de cursada',
                    array('Cuatrimestral', 'Anual'),
                    'Se ingresa el tipo de cursada de la asginatura',
                ),
                new CampoTexto(
                    'horas',
                    'Horas por cuatrimestre o año',
                    '4',
                    'Se ingresa la cantidad de horas por cuatrimestre o año, si se agregan más campos implica que la asignatura sigue y tiene más cantidad de horas en el perído siguiente',
                    true
                ),
            ),
            array('codigo_de_materia','asginatura'),
        ),
        array('codigo_de_materia','asginatura'),
    );
    // $tests = new CreadorTipoDePost(
    //     'test',
    //     'tests',
    //     true,
    //     'INSPT_SISTEMA_DE_INSCRIPCIONES',
    //     'dashicons-bank',
    //     new TipoMetaBox(
    //         'Editor de tests',
    //         array(
    //             new CampoTexto(
    //                 'no_clonable',
    //                 'No clonable',
    //                 'Ejemplo',
    //                 'Descripcion'
    //             ),
    //             new CampoTexto(
    //                'Clonable',
    //                 'clonable',
    //                 'Ejemplo',
    //                 'Descripcion',
    //                 true
    //             ),
    //         ),
    // 'no_clonable'
    //     ),
    //     array('no_clonable'),
    // );
=======
                new MetaBoxTipoTextoClonable(
                    'consultas_a',
                    'Consultas a',
                    'info@inspt.utn.edu.ar',
                    'Se ingresa un métodode contácto por cada casilla, de ser necesario se generan más'
                ),
            )
        ),
        array('numero_de_plan_de_la_carrera', 'nombre_de_la_carrera', ),
    );
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
}