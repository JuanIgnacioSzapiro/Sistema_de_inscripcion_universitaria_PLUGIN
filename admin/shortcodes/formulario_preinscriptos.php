<?php
// En tu archivo functions.php o en un plugin personalizado

// 1. Crear el shortcode
add_shortcode('formulario_preinscriptos', 'formulario_preinscriptos_shortcode');
function formulario_preinscriptos_shortcode()
{
    $carreras = array(
        new CampoDropDownTipoPost(
            'carreras',
            'Carreras a la que está inscripta',
            'carreras',
            'Se selecciona las carrera, previamente creada y publicada',
        ),
    );
    $datos_personales = array(
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
    );
    $nacimiento = array(
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
    );
    $dommicilio = array(
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
    );
    $contacto = array(
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
    );
    $contacto_emergencia = array(
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
    );
    $secundario = array(
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
    );
    $otros_estudios = array(
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
    );
    $trabajo = array(
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
    );
    $familia = array(
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
    );
    $padre = array(
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
    );
    $madre = array(
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
    );
    ob_start();
    ?>
    <div class="formulario">
        <h2>INGRESO 2025</h2>
        <p>A continuación, te pediremos algunos datos para completar la preinscripción. Te sugerimos que revises la
            información que cargues ya que reviste carácter de Declaración Jurada.</p>
        <p>Recordamos que la vacante quedará reservada una vez que presentes en nuestra sede de Av. Triunvirato 3174,
            CABA, de 9 a 20 hs., toda la documentación requerida (ver requisitos en la página web)</p>
        <h3>Carrera</h3>
        <?php
        recorrer_array($carreras);
        ?>
        <h3>Datos personales</h3>
        <?php
        recorrer_array($datos_personales);
        ?>
        <h3>Nacimiento</h3>
        <?php
        recorrer_array($nacimiento);
        ?>
        <h3>Domicilio (como figura en su documento)</h3>
        <?php
        recorrer_array($dommicilio);
        ?>
        <h3>Contacto</h3>
        <?php
        recorrer_array($contacto);
        ?>
        <h3>¿A quién recurrir en caso de que lo necesites?</h3>
        <?php
        recorrer_array($contacto_emergencia);
        ?>
        <h3>Secundario</h3>
        <?php
        recorrer_array($secundario);
        ?>
        <h3>Otros Estudios</h3>
        <?php
        recorrer_array($otros_estudios);
        ?>
        <h3>Trabajo</h3>
        <?php
        recorrer_array($trabajo);
        ?>
        <h3>Familia</h3>
        <?php
        recorrer_array($familia);
        ?>
        <h3>Padre</h3>
        <?php
        recorrer_array($padre);
        ?>
        <h3>Madre</h3>
        <?php
        recorrer_array($madre);
        ?>

    </div>
    <?php
    return ob_get_clean();
}

function recorrer_array($xs)
{
    foreach ($xs as $x) {
        ?>
        <div class="en-meta-box">
            <?php
            $x->generar_fragmento_html_formulario($GLOBALS['prefijo_variables_sql']);
            ?>
        </div>
        <?php
    }
}