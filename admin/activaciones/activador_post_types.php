<?php
require_once dirname(__FILE__) . '/../post_type/generador_post_type.php';
require_once dirname(__FILE__) . '/../post_type/mis_post_type/generar_post_type_general.php';
require_once dirname(__FILE__) . '/../post_type/meta-box/meta_box_drop_down_predeterminado.php';


function activar_post_types()
{
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
                new CampoTexto(
                    'periodo_en_que_aplica',
                    'Periodo en el que aplica',
                    '1',
                    'Se ingresa el periodo de la totalidad de la cursada en el que aplica. Se ingresa "1" para indicar que es para primer año 1. En caso de ser más de un periodo para el cual está la materia se agrega un campo el cual coincidirá con ',
                    true,
                    'int',
                ),
                new CampoTexto(
                    'horas',
                    'Horas por año o cuatrimestre',
                    '4',
                    'Se ingresa la cantidad de horas por cursada',
                    true,
                    'int'
                ),
            ),
            array('codigo_de_materia', 'asginatura'),
        ),
        array('codigo_de_materia', 'asginatura'),
    );
    $planes_y_programas = new CreadorTipoDePost(
        'plan_y_programa',
        'planes_y_programas',
        false,
        'INSPT_SISTEMA_DE_INSCRIPCIONES',
        'dashicons-bank',
        new TipoMetaBox(
            'Editor de planes y programas',
            array(
                new CampoTexto(
                    'nombre_de_plan_y_programa',
                    'Nombre de planes de estudios y programas de la carrera',
                    'Informática Aplicada 2025',
                    'Se ingresa el nombre del plane de estudios y programas de la carrera'
                ),
                new CampoDropDownTipoPost(
                    'materias',
                    'Materias',
                    'materias',
                    'Seleccionar las materias',
                    true
                ),
                new CampoDropDownPredeterminado(
                    'tipo_de_cursada',
                    'Tipo de cursada',
                    array('Cuatrimestral', 'Anual'),
                    'Se ingresa el tipo de cursada de la carrera',
                ),
            ),
            array('nombre_de_plan_y_programa'),
        ),
        array('nombre_de_plan_y_programa'),
    );
    $tipo_de_carrera = new CreadorTipoDePost(
        'tipo_de_carrera',
        'tipos_de_carrera',
        false,
        'INSPT_SISTEMA_DE_INSCRIPCIONES',
        'dashicons-bank',
        new TipoMetaBox(
            'Editor de tipos de carrera',
            array(
                new CampoTexto(
                    'nombre_tipo_de_carrera',
                    'Nombre tipo del tipo de carrera',
                    'Tecnicaturas Superiores',
                    'Se ingresa el nombre del tipo de la carrera'
                ),
                new CampoTexto(
                    'descripcion_tipo_de_carrera',
                    'Descripción breve del tipo del tipo de carrera',
                    'Títulos con reconocimiento oficial y validez nacional otorgados por el Ministerio de Educación de la Nación Argentina
con especialidad en:',
                    'Se ingresa una descripción breve del tipo de la carrera'
                ),
            ),
            array('nombre_tipo_de_carrera'),
        ),
        array('nombre_tipo_de_carrera'),
    );
    $carreras = new CreadorTipoDePost(
        'carrera',
        'carreras',
        true,
        'INSPT_SISTEMA_DE_INSCRIPCIONES',
        'dashicons-bank',
        new TipoMetaBox(
            'Editor de carreras',
            array(
                new CampoTexto(
                    'numero_de_plan_de_la_carrera',
                    'Número de plan de la carrera',
                    '60',
                    'Se ingresa el número del plan de la carrera'
                ),
                new CampoTexto(
                    'nombre_de_la_carrera',
                    'Nombre de la carrera',
                    'Tecnicatura Superior en Informática Aplicada',
                    'Se ingresa el nombre completo de la carrera'
                ),
                new CampoDropDownTipoPost(
                    'tipos_de_carrera',
                    'Tipo de carrera',
                    'tipos_de_carrera',
                    'Se selecciona el tipo de carrera'
                ),
                new CampoTexto(
                    'descripcion_corta_de_la_carrera',
                    'Descripción corta de la carrera',
                    'Tecnicatura Superior + un año de formación Docente',
                    'Se ingresa una descripción de la carrera que aparece en la galería de carreras'
                ),
                new CampoTexto(
                    'descripcion_de_la_carrera',
                    'Descripción de la carrera',
                    'El/la Técnico/a Superior en Informática Aplicada tendrá como área de acción principal la problemática de la construcción de software, que se corresponde con las tareas tradicionalmente conocidas como análisis, diseño y programación (...)',
                    'Se ingresa una descripción de la carrera'
                ),
                new CampoTexto(
                    'profesional_en_condiciones_de_la_carrera',
                    'Profesional en condiciones de la carrera',
                    'Realizar el análisis y especificación formal, diseño, codificación, implementación, prueba, verificación, documentación, mantenimiento y (...)',
                    'Se ingresa una por cada ítem en su respectiva casilla, de ser necesario se generan más',
                    true
                ),
                new CampoTexto(
                    'resolucion_ministerial_de_la_carrera',
                    'Resolución ministerial de la carrera',
                    'https://inspt.utn.edu.ar/este-es-un-ejemplo.pdf',
                    'Link de la resolución ministerial'
                ),
                new CampoDropDownTipoPost(
                    'planes_y_programas',
                    'Plan de estudios y Programas de la carrera ',
                    'planes_y_programas',
                    'Se selecciona un plan de estudio, previamente creado y publicado',
                ),
                new CampoArchivo(
                    'correlatividades_del_acarrera',
                    'Correlatividades del acarrera',
                    'application/pdf',
                    'Subir archivo .pdf'
                ),
                new CampoArchivo(
                    'horarios_turno_manana_de_la_carrera',
                    'Horarios Turno Mañana de la carrera',
                    'application/pdf',
                    'Subir archivo .pdf'
                ),
                new CampoArchivo(
                    'horarios_turno_tarde_de_la_carrera',
                    'Horarios Turno Tarde de la carrera',
                    'application/pdf',
                    'Subir archivo .pdf'
                ),
                new CampoArchivo(
                    'horarios_turno_noche_de_la_carrera',
                    'Horarios Turno Noche de la carrera',
                    'application/pdf',
                    'Subir archivo .pdf'
                ),
                new CampoArchivo(
                    'mesas_de_examen_turno_manana_de_la_carrera',
                    'Mesas de examen turno mañana de la carrera',
                    'application/pdf',
                    'Subir archivo .pdf'
                ),
                new CampoArchivo(
                    'mesas_de_examen_turno_tarde_de_la_carrera',
                    'Mesas de examen turno tarde de la carrera',
                    'application/pdf',
                    'Subir archivo .pdf'
                ),
                new CampoArchivo(
                    'mesas_de_examen_turno_noche_de_la_carrera',
                    'Mesas de examen turno noche de la carrera',
                    'application/pdf',
                    'Subir archivo .pdf'
                ),
                new CampoTexto(
                    'nombre_de_la_direccion_de_la_carrera',
                    'Nombre de la dirección de la carrera',
                    'Dra. Paula Ithurralde',
                    ''
                ),
                new CampoTexto(
                    'descripcion_de_la_direccion_de_la_carrera',
                    'Descripción de la dirección de la carrera',
                    'Paula Ithurralde es técnica en administración y gestión universitaria, titulación otorgada (...)',
                    ''
                ),
                new CampoTexto(
                    'nombre_del_referente_de_laboratorio',
                    'Nombre del referente de laboratorio',
                    'Prof. Matías Garcia',
                    ''
                ),
                new CampoTexto(
                    'descripcion_del_referente_de_laboratorio',
                    'Descripción del referente de laboratorio',
                    'Profesor y Técnico en Informática Aplicada, egresado del Instituto Nacional Superior del (...)',
                    ''
                ),
                new CampoTexto(
                    'grado_academico',
                    'Grado académico',
                    'Pregado',
                    ''
                ),
                new CampoTexto(
                    'modalidad',
                    'Modalidad',
                    'Presencial',
                    ''
                ),
                new CampoTexto(
                    'consultas_a',
                    'Consultas a',
                    'info@inspt.utn.edu.ar',
                    'Se ingresa un métodode contácto por cada casilla, de ser necesario se generan más',
                    true
                ),
            ),
            array('nombre_de_la_carrera')
        ),
        array('numero_de_plan_de_la_carrera', 'nombre_de_la_carrera'),
    );
}