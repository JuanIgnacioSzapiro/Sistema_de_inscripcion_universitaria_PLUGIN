<?php
require_once dirname(__FILE__) . '/../post_type/generador_post_type.php';
require_once dirname(__FILE__) . '/../post_type/generar_cuerpo_post_type.php';
require_once dirname(__FILE__) . '/../post_type/meta-box/meta_box_drop_down_predeterminado.php';
require_once dirname(__FILE__) . '/../post_type/meta-box/meta_box_tipo_texto_asociado.php';

function activar_post_types()
{
    $materias = new CuerpoPostType(
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
                    'Código de la materia:',
                    '60101',
                    'Se ingresa el código de la materia.',
                ),
                new CampoTexto(
                    'asginatura',
                    'Asignatura:',
                    'Análisis Matemático I',
                    'Se ingresa el código de la asginatura.'
                ),
                new CampoTextoAsociado(
                    'periodo_en_que_aplica',
                    'Periodo en el que aplica:',
                    '1',
                    'Se ingresa el periodo.',
                    'horas',
                    'Horas por año o cuatrimestre:',
                    '4',
                    'Se ingresa la cantidad.',
                    'int',
                    'int',
                    true,
                )
            ),
            array('codigo_de_materia', 'asginatura'),
        ),
        array('codigo_de_materia', 'asginatura'),
    );
    $planes_y_programas = new CuerpoPostType(
        'plan y programa',
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
    $tipo_de_carrera = new CuerpoPostType(
        'tipo de carrera',
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
                    'Se ingresa una descripción breve del tipo de la carrera',
                    false,
                    'string',
                    true
                ),
            ),
            array('nombre_tipo_de_carrera'),
        ),
        array('nombre_tipo_de_carrera'),
    );
    $carreras = new CuerpoPostType(
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
                new CampoArchivo(
                    'imagen_para_galeria',
                    'Ingresar la imágen de la carrera para la galería',
                    ['image/jpeg', 'image/png'],
                    'Subir imágen'
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
                    'reconocimiento_CABA',
                    'Reconocimiento CABA',
                    ["application/pdf"],
                    'Subir archivo .pdf',
                    false,
                    true,
                ),
                new CampoArchivo(
                    'reconocimiento_PBA',
                    'Reconocimiento PBA',
                    ["application/pdf"],
                    'Subir archivo .pdf',
                    false,
                    true,
                ),
                new CampoArchivo(
                    'horarios_turno_manana_de_la_carrera',
                    'Horarios Turno Mañana de la carrera',
                    ["application/pdf"],
                    'Subir archivo .pdf'
                ),
                new CampoArchivo(
                    'horarios_turno_tarde_de_la_carrera',
                    'Horarios Turno Tarde de la carrera',
                    ["application/pdf"],
                    'Subir archivo .pdf'
                ),
                new CampoArchivo(
                    'horarios_turno_noche_de_la_carrera',
                    'Horarios Turno Noche de la carrera',
                    ["application/pdf"],
                    'Subir archivo .pdf'
                ),
                new CampoArchivo(
                    'mesas_de_examen_turno_manana_de_la_carrera',
                    'Mesas de examen turno mañana de la carrera',
                    ["application/pdf"],
                    'Subir archivo .pdf'
                ),
                new CampoArchivo(
                    'mesas_de_examen_turno_tarde_de_la_carrera',
                    'Mesas de examen turno tarde de la carrera',
                    ["application/pdf"],
                    'Subir archivo .pdf'
                ),
                new CampoArchivo(
                    'mesas_de_examen_turno_noche_de_la_carrera',
                    'Mesas de examen turno noche de la carrera',
                    ["application/pdf"],
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
                    'mail_de_la_carrera',
                    'Mail de la carrera',
                    'informatica.aplicada@inspt.utn.edu.ar',
                    'Se ingresa el mail de la carrera',
                ),
                new CampoTexto(
                    'consultas_a',
                    'Consultas a',
                    'info@inspt.utn.edu.ar',
                    'Se ingresa el texto correspondiente y agregan líneas a medida que se necesitan más párrafos',
                    true
                ),
            ),
            array('nombre_de_la_carrera')
        ),
        array('numero_de_plan_de_la_carrera', 'nombre_de_la_carrera'),
    );
    $documentacion = new CuerpoPostType(
        'documentacion requerida',
        'documentacion',
        true,
        'INSPT_SISTEMA_DE_INSCRIPCIONES',
        'dashicons-bank',
        new TipoMetaBox(
            'Editor de documentacion requerida',
            array(
                new CampoDropDownTipoPost(
                    'carreras',
                    'Carreras que requieren la misma documentación',
                    'carreras',
                    'Se selecciona las carreras, previamente creadas y publicadas',
                    true
                ),
                new CampoTexto(
                    'documentacion_necesaria',
                    'Documentación necesaria para la inscripción',
                    '- Título secundario original legalizado (*) y fotocopia (frente y dorso).',
                    'Se ingresa el texto correspondiente y agregan líneas a medida que se necesitan más párrafos',
                    true
                ),
                new CampoArchivo(
                    'tipo_de_ingreso',
                    'Tipo de ingreso',
                    ["application/pdf"],
                    'Subir archivo .pdf',
                    false,
                    true
                ),
                new CampoArchivo(
                    'modelos_de_examen',
                    'Modelos de examen',
                    ["application/pdf"],
                    'Subir archivo .pdf',
                    true,
                    true
                ),
                new CampoTexto(
                    'condiciones_de_ingreso',
                    ' Condiciones de ingreso',
                    'Poseer título profesional universitario con título de grado de cuatro (4) años de duración y una carga mínima de 2.600 horas reloj, en las áres de la Ciencia y de la Técnica',
                    'Se ingresa el texto correspondiente y agregan líneas a medida que se necesitan más párrafos',
                    true,
                    'string',
                    true
                ),
                new CampoTexto(
                    'costos',
                    'Costos',
                    'Carrera NO ARANCELADA',
                    'Se ingresa el monto o "Carrera NO ARANCELADA respectivamente"',
                ),
                new CampoTexto(
                    'condiciones_de_asistencia',
                    'Condiciones de asistencia',
                    'Es necesario el 75% (setenta y cinco por ciento) de asistencia para ser alumno regular',
                    'Se ingresa un texto con el porcentaje de asistencia para regularizar la carrera',
                ),
                new CampoTexto(
                    'equivalencias',
                    'Equivalencias',
                    'Si querés solicitar equivalencias comunícate vía mail a equivalencias@inspt.utn.edu.ar',
                    'Se ingresa el texto correspondiente y agregan líneas a medida que se necesitan más párrafos',
                    true
                ),
            ),
            array('carreras'),
        ),
        array(),
    );
}