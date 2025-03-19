<?php
// En tu archivo functions.php o en un plugin personalizado

// 1. Crear el shortcode
add_shortcode('formulario_preinscriptos', 'formulario_preinscriptos_shortcode');
function formulario_preinscriptos_shortcode()
{
    $preguntas = array(
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
            '+54 - 15 - 911 1111 1111',
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
        new CampoTexto(
            'tel_movil_de_emergencia',
            'Teléfonos móvil de emergencia',
            '+54 - 15 - 911 1111 1111',
            'Se ingresan los teléfonos móviles',
            true,
            'string',
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
            true
        ),
    );

    ob_start();
    ?>
    <div class="formulario">
        <?php
        foreach ($preguntas as $pregunta) {
            ?>
            <div class="en-meta-box">
                <?php
                $pregunta->generar_fragmento_html_formulario($GLOBALS['prefijo_variables_sql']);
                ?>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
    return ob_get_clean();
}