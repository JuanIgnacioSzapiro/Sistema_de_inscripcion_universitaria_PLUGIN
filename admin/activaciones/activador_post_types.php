<?php
require_once dirname(__FILE__) . '/../post_type/generador_post_type.php';
require_once dirname(__FILE__) . '/../post_type/generar_cuerpo_post_type.php';
require_once dirname(__FILE__) . '/../post_type/meta-box/meta_box_drop_down_predeterminado.php';
require_once dirname(__FILE__) . '/../post_type/meta-box/meta_box_tipo_texto_asociado.php';
require_once dirname(__FILE__) . '/../post_type/meta-box/meta_box_area_de_texto.php';
require_once dirname(__FILE__) . '/../post_type/meta-box/meta_box_checkbox.php';
require_once dirname(__FILE__) . '/../post_type/meta-box/meta_box_fecha.php';

function activar_post_types()
{
    $prefijo = 'INSPT_SISTEMA_DE_INSCRIPCIONES';

    $links_preinscripciones = new CuerpoPostType(
        'link de inscripciones',
        'Link de inscripciones',
        'links_preinscriptos',
        false,
        $prefijo,
        'dashicons-admin-links',
        new TipoMetaBox(
            'Editor de materias',
            array(
                new CampoDropDownTipoPost(
                    'link_documentacion',
                    'Página de documentación requerida',
                    'page',
                    'Se selecciona la página de documentación requerida para la inscripción'
                ),
                new CampoDropDownTipoPost(
                    'link_previo_preinscripcion',
                    'Página del formulario previo',
                    'page',
                    'Se selecciona la página del formulario previo a la preinscripción'
                ),
                new CampoDropDownTipoPost(
                    'link_preinscripcion',
                    'Página del formulario',
                    'page',
                    'Se selecciona la página del formulario para la preinscripción'
                )
            )
            ,
            array('page'),
        ),
        array('page')
    );
    $materias = new CuerpoPostType(
        'materia',
        'Materias',
        'materias',
        true,
        $prefijo,
        'dashicons-text-page',
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
        'Planes y programas',
        'planes_y_programas',
        false,
        $prefijo,
        'dashicons-book',
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
        'Tipo de carreras',
        'tipos_de_carrera',
        false,
        $prefijo,
        'dashicons-book-alt',
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
        'Carreras',
        'carreras',
        true,
        $prefijo,
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
                    'Se ingresa una descripción de la carrera que aparece en la galería de carreras',
                    false,
                    'string',
                    true
                ),
                new CampoAreaDeTexto(
                    'descripcion_de_la_carrera',
                    'Descripción de la carrera',
                    'El/la Técnico/a Superior en Informática Aplicada tendrá como área de acción principal la problemática de la construcción de software, que se corresponde con las tareas tradicionalmente conocidas como análisis, diseño y programación (...)',
                    'Se ingresa una descripción de la carrera'
                ),
                new CampoAreaDeTexto(
                    'profesional_en_condiciones_de_la_carrera',
                    'Profesional en condiciones de la carrera',
                    'Realizar el análisis y especificación formal, diseño, codificación, implementación, prueba, verificación, documentación, mantenimiento y (...)',
                    'Se ingresa un párrafo por cada ítem en su respectiva casilla, de ser necesario se generan más',
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
                new CampoAreaDeTexto(
                    'perfil_del_egresado',
                    'Perfil del egresado',
                    'El egresado del PDI Presencial podrá ejercer la docencia desplegando enfoques pedagógicos, políticos y filosóficos (...)',
                    'Se ingresa un párrafo por cada ítem en su respectiva casilla, de ser necesario se generan más',
                    true,
                    'string',
                    true
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
                new CampoAreaDeTexto(
                    'descripcion_de_la_direccion_de_la_carrera',
                    'Descripción de la dirección de la carrera',
                    'Paula Ithurralde es técnica en administración y gestión universitaria, titulación otorgada (...)',
                    '',
                    false,
                    'string',
                    true
                ),
                new CampoTexto(
                    'nombre_del_referente_de_laboratorio',
                    'Nombre del referente de laboratorio',
                    'Prof. Matías Garcia',
                    ''
                ),
                new CampoAreaDeTexto(
                    'descripcion_del_referente_de_laboratorio',
                    'Descripción del referente de laboratorio',
                    'Profesor y Técnico en Informática Aplicada, egresado del Instituto Nacional Superior del (...)',
                    '',
                    false,
                    'string',
                    true
                ),
                new CampoTexto(
                    'grado_academico',
                    'Grado académico',
                    'Pregado',
                    '',
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
                    false,
                    'string',
                    true
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
        array('numero_de_plan_de_la_carrera', 'nombre_de_la_carrera', 'tipos_de_carrera'),
    );
    $documentacion = new CuerpoPostType(
        'documentación',
        'Documentaciones',
        'doc',
        true,
        $prefijo,
        'dashicons-media-document',
        new TipoMetaBox(
            'Editor de documentación',
            array(
                new CampoTexto(
                    'nombre_del_documento',
                    'Documento requerido',
                    'Título secundario original legalizado (*) y fotocopia (frente y dorso)',
                    'Se ingresa el documento requerido',
                ),
                new CampoTexto(
                    'aclaracion',
                    'Aclaración sobre el documento',
                    ' *En el caso de no poseer el título secundario, se debe presentar Constancia de título en trámite o bien, Constancia original de alumno regular o de Materias Adeudadas (5to/6to año) – original y fotocopia',
                    'Se ingresa una aclaración corta sobre ese documento',
                    true,
                    'string',
                    true
                )
            ),
            array('nombre_del_documento')
        ),
        array()
    );
    $doc_total = new CuerpoPostType(
        'documentación requerida',
        'Documentación requerida',
        'doc_total',
        true,
        $prefijo,
        'dashicons-media-document',
        new TipoMetaBox(
            'Editor de documentación requerida',
            array(
                new CampoDropDownTipoPost(
                    'carreras',
                    'Carreras que requieren la misma documentación',
                    'carreras',
                    'Se selecciona las carreras, previamente creadas y publicadas',
                    true
                ),
                new CampoDropDownTipoPost(
                    'doc',
                    'Documentación requerida',
                    'doc',
                    'Se selecciona las documentaciones, previamente creadas y publicadas',
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
                    'Condiciones de ingreso',
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
    $pre_form_ingreso = $form_ingreso = new CuerpoPostType(
        'formulario previo al formulario pre ingreso',
        'Formulario previo al formulario pre ingreso',
        'pre_form_ingreso',
        false,
        $prefijo,
        'dashicons-editor-paste-text',
        new TipoMetaBox(
            'Editor de formulario previo al pre ingreso',
            array(
                new CampoTexto(
                    'dni',
                    'DNI',
                    '11.111.111',
                    'Se ingresa el DNI',
                ),
                new CampoTexto(
                    'apellidos',
                    'Apellidos',
                    'Doe',
                    'Se ingresan los apellidos',
                ),
                new CampoTexto(
                    'nombres',
                    'Nombres',
                    'John',
                    'Se ingresan los nombres',
                ),
                new CampoTexto(
                    'mails_de_contacto',
                    'Mails de contacto',
                    'john.doe@gmail.com',
                    'Se ingresan los mails',
                    true
                ),
            ),
            array('dni', 'apellidos')
        ),
        array('dni', 'apellidos', 'mails_de_contacto')
    );
    $form_ingreso = new CuerpoPostType(
        'formulario pre ingreso',
        'Formulario pre ingreso',
        'form_ingreso',
        false,
        $prefijo,
        'dashicons-editor-paste-text',
        new TipoMetaBox(
            'Editor de formulario pre ingreso',
            array(
                new CampoTexto(
                    'dni',
                    'DNI',
                    '11.111.111',
                    'Se ingresa el DNI',
                ),
                new CampoTexto(
                    'apellidos',
                    'Apellidos',
                    'Doe',
                    'Se ingresan los apellidos',
                ),
                new CampoTexto(
                    'nombres',
                    'Nombres',
                    'John',
                    'Se ingresan los nombres',
                ),
                new CampoTexto(
                    'mails_de_contacto',
                    'Mails de contacto',
                    'john.doe@gmail.com',
                    'Se ingresan los mails',
                    true
                ),
                new CampoTexto(
                    'cuil',
                    'CUIL',
                    '11.11.111.111.1',
                    'Se ingresan el CUIL',
                    false,
                    'string',
                    true
                ),
                new CampoDropDownPredeterminado(
                    'genero',
                    'Género (como figura en su documento)',
                    array(
                        'Femenino',
                        'Masculino',
                        'No binarie'
                    ),
                    'Se ingresa el género',
                ),
                new CampoDropDownPredeterminado(
                    'estado-civil',
                    'Estado civil',
                    array(
                        'Soltera/o',
                        'Casada/o',
                        'Unión libre o unión de hecho',
                        'Separada/o',
                        'Divorciada/o',
                        'Viuda/o',
                        'Uninón civil'
                    ),
                    'Se ingresa el estado civil',
                    false,
                    true
                ),
                new CampoDropDownPredeterminado(
                    'condicion_de_discapacidad',
                    'Condicion de discapacidad',
                    array(
                        'Declaro condición de discapacidad',
                        'No presento ninguna condición que implique discapacidad'
                    ),
                    'Se ingresa condición',
                    false,
                    true
                ),
                new CampoCheckbox(
                    'posesion_certificado_de_discapacidad',
                    '¿Posee Certificado de Discapacidad Único (CUD)?',
                    'Marcar en caso positivo',
                    array(),
                    true
                ),
                new CampoCheckbox(
                    'discapacidad',
                    'Tipo de discapacidad',
                    'Seleccione todas que apliquen',
                    [
                        'Auditiva',
                        'Visual',
                        'Motora',
                        'Condición psicosocial',
                        'Otras'
                    ],
                    true // opcional
                ),
                new CampoAreaDeTexto(
                    'otra_informacion',
                    'Otra información',
                    '',
                    '',
                    false,
                    'string',
                    true
                ),
                new CampoFecha(
                    'nacimiento',
                    'Fecha de nacimiento',
                    'Ingresar la fecha de nacimiento',
                ),
                new CampoDropDownPredeterminado(
                    'nacionalidad',
                    'Nacionalidad',
                    array(
                        'Extranjero',
                        'Extranjero temporal',
                        'Nativo',
                        'Naturalizado',
                        'Por opción'
                    ),
                    'Se ingresa la nacionalidad',
                ),
                new CampoTexto(
                    'pais_origen',
                    'País de origen',
                    'Argentina',
                    'Se ingresa el país de origen',
                ),
                new CampoTexto(
                    'provincia_origen',
                    'Provincia de origen',
                    'CABA',
                    'Se ingresa el provincia de origen',
                ),
                new CampoTexto(
                    'ciudad_localidad_origen',
                    'Ciudad o localidad de origen',
                    'CABA',
                    'Se ingresa el ciudad de origen',
                ),
                new CampoTexto(
                    'calle',
                    'Calle de residencia',
                    'Tronador',
                    'Se ingresa el país de residencia',
                ),
                new CampoTexto(
                    'numero',
                    'Número de residencia',
                    '1111',
                    'Se ingresa el Piso de residencia',
                ),
                new CampoTexto(
                    'piso',
                    'Piso de residencia',
                    '5',
                    'Se ingresa el país de residencia',
                    false,
                    'string',
                    true
                ),
                new CampoTexto(
                    'ciudad_localidad',
                    'Ciudad o localidad de residencia',
                    'CABA',
                    'Se ingresa la ciudad de residencia',
                ),
                new CampoTexto(
                    'provincia',
                    'Provincia de residencia',
                    'CABA',
                    'Se ingresa la provincia de residencia',
                ),
                new CampoTexto(
                    'codigo_postal',
                    'Código postal',
                    '1419',
                    'Se ingresa el código postal',
                ),
                new CampoTexto(
                    'tel_fijo',
                    'Teléfono fijo',
                    '11 - 111 111',
                    'Se ingresa número de teléfono fijo',
                    true,
                    'string',
                    true
                ),
                new CampoTexto(
                    'tel_movil',
                    'Teléfono móvil',
                    '+54 911 1111 1111',
                    'Se ingresa número de teléfono móvil',
                    true,
                    'string',
                    true
                ),
                new CampoTexto(
                    'mails_de_emergencia',
                    'Email de emergencia',
                    'john.doe@gmail.com',
                    'Se ingresan los mails',
                    true,
                    'string',
                    true
                ),
                new CampoTextoAsociado(
                    'contacto_emergencia_nombre',
                    'Nombre del contacto',
                    'John Doe',
                    'Se ingresa el nombre.',
                    'contacto_emergencia_tel_movil',
                    'Teléfonos móvil',
                    '+54 911 1111 1111',
                    'Se ingresa número de teléfono móvil',
                    'string',
                    'string',
                    true,
                    true
                ),
                new CampoTexto(
                    'nombre_título_secundario',
                    'Nombre del título secundario obtenido o a obtener',
                    '',
                    'Se ingresa el nombre del título',
                    false,
                    'string',
                    true

                ),
                new CampoDropDownPredeterminado(
                    'tecnico',
                    'Secundario técnico',
                    array('Sí', 'No'),
                    'Marcar en caso afirmativo',
                    false,
                    true
                ),
                new CampoDropDownPredeterminado(
                    'tipo_otro_estudio',
                    'Tipo',
                    array(
                        'Universitario',
                        'Terciario',
                        'Otro',
                    ),
                    'Se ingresa el tipo de carrera',
                    false,
                    true
                ),
                new CampoTexto(
                    'carrera_otro_estudio',
                    'Nombre del título',
                    '',
                    'Se ingresa el nombre del título',
                    false,
                    'string',
                    true
                ),
                new CampoTexto(
                    'institucion_otro_estudio',
                    'Nombre de la institución',
                    '',
                    'Se ingresa el nombre de la institución',
                    false,
                    'string',
                    true
                ),
                new CampoDropDownPredeterminado(
                    'estado_otro_estudio',
                    'Estado',
                    array(
                        'Finalizado',
                        'En curso',
                        'Abandonado',
                    ),
                    'Se ingresa el estado de carrera',
                    false,
                    true
                ),
                new CampoDropDownPredeterminado(
                    'trabajo',
                    'Situación Laboral',
                    array(
                        'Desocupado, NO buscando',
                        'Desocupado, buscando',
                        'Trabaja',
                    ),
                    'Se ingresa el situación laboral',
                    false,
                    true
                ),
                new CampoDropDownPredeterminado(
                    'hijos_a_cargo',
                    'Cantidad de hijos a cargo',
                    array(
                        'No tiene',
                        '1 (uno)',
                        '2 (dos)',
                        'Más de 2 (dos)',
                    ),
                    'Se ingresa la cantidad de hijos a cargo',
                    false,
                    true
                ),
                new CampoDropDownPredeterminado(
                    'familia_a_cargo',
                    'Cantidad de familia a cargo sin contar a los hijos',
                    array(
                        'No tiene',
                        '1 (uno)',
                        '2 (dos)',
                        'Más de 2 (dos)',
                    ),
                    'Se ingresa la cantidad a cargo sin contar a los hijos',
                    false,
                    true
                ),
                new CampoTexto(
                    'apellido_padre',
                    'Apellido del padre',
                    '',
                    'Se ingresa el apellido',
                    false,
                    'string',
                    true
                ),
                new CampoTexto(
                    'nombre_padre',
                    'Nombre del padre',
                    '',
                    'Se ingresa el nombre',
                    false,
                    'string',
                    true
                ),
                new CampoFecha(
                    'nacimiento_padre',
                    'Fecha de nacimiento del padre',
                    'Ingresar la fecha de nacimiento',
                    true
                ),
                new CampoDropDownPredeterminado(
                    'vive_padre',
                    'Vive?',
                    array(
                        'Sí',
                        'No',
                        'Se desconoce',
                    ),
                    '',
                    false,
                    true
                ),
                new CampoTexto(
                    'apellido_madre',
                    'Apellido de la madre',
                    '',
                    'Se ingresa el apellido',
                    false,
                    'string',
                    true
                ),
                new CampoTexto(
                    'nombre_madre',
                    'Nombre de la madre',
                    '',
                    'Se ingresa el nombre',
                    false,
                    'string',
                    true
                ),
                new CampoFecha(
                    'nacimiento_madre',
                    'Fecha de nacimiento de la madre',
                    'Ingresar la fecha de nacimiento',
                    true
                ),
                new CampoDropDownPredeterminado(
                    'vive_madre',
                    'Vive?',
                    array(
                        'Sí',
                        'No',
                        'Se desconoce',
                    ),
                    '',
                    false,
                    true
                ),
                new CampoDropDownTipoPost(
                    'carreras',
                    'Carreras a la que está inscripta',
                    'carreras',
                    'Se selecciona las carrera, previamente creada y publicada',
                ),
                // new CampoCheckbox(
                //     'frente_y_dorso_titulo_secundario',
                //     'Entregó fotocopia frente y dorso del título secundario',
                //     'Marcar si se hizo entrega',
                // ),
                // new CampoCheckbox(
                //     'frente_y_dorso_titulo_secundario',
                //     'Entregó fotocopia frente y dorso de la constancia de título en trámite o bien, constancia original de alumno regular o de materias adeudadas (5to/6to año)',
                //     'Marcar si se hizo entrega',
                //     array(),
                //     true
                // ),
                // new CampoCheckbox(
                //     'frente_y_dorso_dni',
                //     'Entregó fotocopia frente y dorso del DNI',
                //     'Marcar si se hizo entrega',
                // ),
                // new CampoCheckbox(
                //     'fotos_4x4',
                //     'Entregó 3 Fotos color 4 x 4',
                //     'Marcar si se hizo entrega',
                // ),
                // new CampoCheckbox(
                //     'constancia_cuil',
                //     'Fotocopia de constancia de CUIL',
                //     'Marcar si se hizo entrega',
                // ),
                // new CampoCheckbox(
                //     'plan_de_estudio_con_carga_horaria',
                //     'Plan de estudios con totalidad de la carga horaria de la carrera de base en horas reloj',
                //     'Marcar si se hizo entrega',
                //     array(),
                //     true
                // ),
            ),
            array('dni', 'apellidos'),
        ),
        array('dni', 'apellidos', 'mails_de_contacto'),
    );
}