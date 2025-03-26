<?php
function obtener_carreras()
{
    return array(
        new CampoDropDownTipoPost(
            'carreras',
            'Carreras a la que está inscripta',
            'carreras',
            'Se selecciona las carrera, previamente creada y publicada',
        ),
    );
}
function obtener_datos_personales()
{
    return array(
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
}
function obtener_nacimiento()
{
    return array(
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
}
function obtener_dommicilio()
{
    return array(
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
}
function obtener_contacto()
{
    return array(
        new CampoTexto(
            'tel_fijo',
            'Teléfono fijo',
            '11 1111 1111',
            'Se ingresa número de teléfono fijo',
            true,
            'string',
            true
        ),
        new CampoTexto(
            'tel_movil',
            'Teléfono móvil',
            '+54 15 911 1111 1111',
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
}
function obtener_contacto_emergencia()
{
    return array(
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
}

function obtener_secundario()
{
    return array(
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
}

function obtener_otros_estudios()
{
    return array(
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
}

function obtener_trabajo()
{
    return array(
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
}

function obtener_familia()
{
    return array(
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
}

function obtener_padre()
{
    return array(
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
}

function obtener_madre()
{
    return array(
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
}
function obtener_totalidad_campos_formulario_preinscripcion()
{
    $agrupaciones = array(obtener_carreras(), obtener_datos_personales(), obtener_nacimiento(), obtener_dommicilio(), obtener_contacto(), obtener_contacto_emergencia(), obtener_secundario(), obtener_otros_estudios(), obtener_trabajo(), obtener_familia(), obtener_padre(), obtener_madre());
    $totalidad = [];
    foreach ($agrupaciones as $campos) {
        foreach ($campos as $campo) {
            $totalidad[] = $campo;
        }
    }
    return $totalidad;
}

// 1. Crear el shortcode
add_shortcode('formulario_preinscriptos', 'formulario_preinscriptos_shortcode');
function formulario_preinscriptos_shortcode()
{
    $prefijo = obtener_prefijo('_form_ingreso');
    ob_start();
    wp_nonce_field('wp_rest');
    ?>
    <div id="ocultador"></div>
    <div class="formulario">
        <form id="formulario_preinscriptos_shortcode">
            <h2>INGRESO 2025</h2>
            <p>A continuación, te pediremos algunos datos para completar la preinscripción. Te sugerimos que revises la
                información que cargues ya que reviste carácter de Declaración Jurada.</p>
            <p>Recordamos que la vacante quedará reservada una vez que presentes en nuestra sede de Av. Triunvirato 3174,
                CABA, de 9 a 20 hs., toda la documentación requerida (ver requisitos en la página web)</p>
            <h3>Carrera</h3>
            <?php
            recorrer_array(obtener_carreras(), $prefijo);
            ?>
            <h3>Datos personales</h3>
            <?php
            recorrer_array(obtener_datos_personales(), $prefijo);
            ?>
            <h3>Nacimiento</h3>
            <?php
            recorrer_array(obtener_nacimiento(), $prefijo);
            ?>
            <h3>Domicilio (como figura en su documento)</h3>
            <?php
            recorrer_array(obtener_dommicilio(), $prefijo);
            ?>
            <h3>Contacto</h3>
            <?php
            recorrer_array(obtener_contacto(), $prefijo);
            ?>
            <h3>¿A quién recurrir en caso de que lo necesites?</h3>
            <?php
            recorrer_array(obtener_contacto_emergencia(), $prefijo);
            ?>
            <h3>Secundario</h3>
            <?php
            recorrer_array(obtener_secundario(), $prefijo);
            ?>
            <h3>Otros Estudios</h3>
            <?php
            recorrer_array(obtener_otros_estudios(), $prefijo);
            ?>
            <h3>Trabajo</h3>
            <?php
            recorrer_array(obtener_trabajo(), $prefijo);
            ?>
            <h3>Familia</h3>
            <?php
            recorrer_array(obtener_familia(), $prefijo);
            ?>
            <h3>Padre</h3>
            <?php
            recorrer_array(obtener_padre(), $prefijo);
            ?>
            <h3>Madre</h3>
            <?php
            recorrer_array(obtener_madre(), $prefijo);
            ?>
            <button type="submit" class="button">terminar preinscripción</button>
        </form>
        <div id="mensaje"></div>
    </div>
    <script>
        jQuery(document).ready(function ($) {
            $('#formulario_preinscriptos_shortcode').submit(function (e) {
                e.preventDefault();

                var ocultador = document.getElementById('ocultador');

                var form = $(this);
                var nonce = $('#_wpnonce').val(); // Obtener el valor del nonce

                var mensaje_error = document.getElementById('mensaje');

                ocultador.classList.add("cargando");

                if (mensaje_error.innerHTML !== '') {
                    mensaje_error.innerHTML = '';
                }
                mensaje_error.classList.remove("mensaje-de-error");
                mensaje_error.classList.remove("mensaje-de-success");

                $.ajax({
                    type: 'POST',
                    url: '<?php echo esc_url(rest_url('formulario_preinscriptos_shortcode/v1/submit')); ?>',
                    data: form.serialize(),
                    dataType: 'json',
                    headers: {
                        'X-WP-Nonce': nonce // Enviar el nonce en el header
                    },
                    success: function (response) {
                        ocultador.classList.remove("cargando");
                        if (response.success) {
                            mensaje_error.classList.add("mensaje-de-success");

                            response.message.forEach(element => {
                                mensaje_error.innerHTML += '<p>' + element + '</p>';
                            });
                        } else {
                            mensaje_error.classList.add("mensaje-de-error");

                            response.message.forEach(element => {
                                mensaje_error.innerHTML += '<p>' + 'Error: ' + element + '</p>';
                            });
                        }
                    },
                    error: function (xhr) {
                        ocultador.classList.remove("cargando");
                        mensaje_error.innerHTML = 'Errores: ' + xhr.responseText;
                    }
                });
            });
        });
    </script>
    <?php
    return ob_get_clean();
}

add_action('rest_api_init', function () {
    register_rest_route(
        'formulario_preinscriptos_shortcode/v1',
        '/submit',
        array(
            'methods' => 'POST',
            'callback' => 'handle_formulario_preinscriptos_shortcode_submit',
            'permission_callback' => '__return_true' // <- Esto es requerido en WordPress 5.5+
        )
    );
});

function handle_formulario_preinscriptos_shortcode_submit($request)
{
    $prefijo = obtener_prefijo('_form_ingreso');
    // Verificar el nonce desde los headers
    $nonce = isset($_SERVER['HTTP_X_WP_NONCE']) ? sanitize_text_field($_SERVER['HTTP_X_WP_NONCE']) : '';

    if (!wp_verify_nonce($nonce, 'wp_rest')) {
        return new WP_REST_Response([
            'success' => false,
            'message' => 'Nonce de seguridad inválido'
        ], 403);
    }

    // Obtener parámetros del formulario correctamente
    $datos = $request->get_params();

    $errores = validar_datos_formulario_preinscriptos($datos, $prefijo);

    $fecha_valida = obtener_fecha_inscripciones_valida();

    if ($fecha_valida) {
        $errores[] = $fecha_valida;
    }

    if (!empty($errores)) {
        return new WP_REST_Response([
            'success' => false,
            'message' => $errores,
            'data' => $datos
        ], 200);
    } else {
        $datos_sanitizados = sanitizar_datos_formulario_preinscriptos($datos, $prefijo);

        $existe_formulario = obtener_resultado_query("SELECT ID from wp_posts WHERE wp_posts.post_title like '" . $datos_sanitizados[$prefijo . '_dni'] . "%' and wp_posts.post_type like 'form_ingreso'");

        $estado_de_formulario = !empty($existe_formulario) ? obtener_resultado_query("SELECT post_status from wp_posts where wp_posts.ID = " . $existe_formulario[0]->ID)[0]->post_status : '';

        if ($estado_de_formulario == 'publish') {
            return new WP_REST_Response([
                'success' => true,
                'message' => [mensaje_rechazo_formulario_completado_formulario()],
                'data' => $datos
            ], 200);
        } elseif ( // falta la entrega de documentación
            !empty($existe_formulario)
            && $estado_de_formulario == 'draft'
        ) {
            $post_id = $existe_formulario[0]->ID;

            $documentacion_entregada = get_post_meta($post_id, 'INSPT_SISTEMA_DE_INSCRIPCIONES_form_ingreso_documentacion_entregada', true);

            $documentacion_a_entregar = array_map(function ($x) {
                return $x->post_title;
            }, obtener_resultado_query("SELECT post_title from wp_posts where wp_posts.ID IN (SELECT meta_value FROM wp_postmeta WHERE wp_postmeta.post_id = (SELECT ID FROM wp_posts WHERE post_title LIKE CONCAT( '%', (SELECT post_title FROM wp_posts INNER JOIN wp_postmeta on wp_posts.ID = (SELECT meta_value FROM wp_postmeta WHERE wp_postmeta.meta_key = 'INSPT_SISTEMA_DE_INSCRIPCIONES_form_ingreso_carreras' AND wp_postmeta.post_id = " . $post_id . ") limit 1), '%') and wp_posts.post_type = 'doc_total' and wp_posts.post_status like 'publish' ORDER BY wp_posts.post_date DESC LIMIT 1) AND wp_postmeta.meta_key like 'INSPT_SISTEMA_DE_INSCRIPCIONES_doc_total_doc') and wp_posts.post_status LIKE 'publish' ORDER by wp_posts.post_title ASC;"));

            $documentacion_faltante = array_diff($documentacion_a_entregar, !empty($documentacion_entregada) ? $documentacion_entregada : array());

            $mensaje_total = mensaje_rechazo_formulario_incompleto_formulario($documentacion_faltante);

            enviar_mail($datos_sanitizados[$prefijo . '_mails_de_contacto'], $datos_sanitizados[$prefijo . '_carreras'], $mensaje_total);

            return new WP_REST_Response([
                'success' => true,
                'message' => [$mensaje_total],
                'data' => $datos_sanitizados
            ], 200);
        } else {
            wp_set_current_user(1);

            $nuevo_formulario = array(
                'post_title' => $datos_sanitizados[$prefijo . '_dni'] . ' - ' . $datos_sanitizados[$prefijo . '_apellidos'],
                'post_status' => 'draft', // Cambiado a publish para crear como publicado
                'post_type' => 'form_ingreso',
                'post_author' => 1
            );

            $post_id = wp_insert_post($nuevo_formulario);

            // Verificar que se creó correctamente el post
            if ($post_id && !is_wp_error($post_id)) {
                // Guardar cada campo como metadato
                foreach ($datos_sanitizados as $key => $dato) {
                    actualizar_data($post_id, $key, $dato);
                }
            }

            enviar_mail($datos_sanitizados[$prefijo . '_mails_de_contacto'], $datos_sanitizados[$prefijo . '_carreras'], mensaje_aceptacion_formulario($datos_sanitizados[$prefijo . '_apellidos'] . '; ' . $datos_sanitizados[$prefijo . '_nombres']));

            wp_set_current_user(get_current_user_id());
            return new WP_REST_Response([
                'success' => true,
                'message' => [repuesta_succes_formulario()],
                'data' => $datos
            ], 200);
        }
    }
}
function repuesta_succes_formulario()
{
    return '<p>Se realizó la preinscripción correctamente. Enviamos un correo electrónico con la información de su preinscripción.</p>' . '<p><b>IMPORTANTE:</b> La preinscripción será finalizada una vez que hayas presentando la documentación requerida en la sede dentro de los plazos establecidos por el INSPT.</p>';
}

function mensaje_aceptacion_formulario($persona)
{
    return '<p>Bienvenida/o ' . $persona . '</p>
    <p>El número de registro es para confirmarle que la preinscripción fue realizada correctamente pero no será utilizado en ningún otro trámite, solo si desea hacer una consulta sobre su preinscripción deberá hacer referencia a este número.</p>
    <p>Te recordamos que la vacante quedará reservada una vez que hayas presentado en nuestra sede de Av. Triunvirato 3174, CABA, de 9 a 20 hs., toda la documentación requerida.</p>
    <p>Fechas para entrega de documentación para inscribirse:</p>
    <p>Del ' . obtener_fechas_entrega_documentacion()[0] . ' al ' . obtener_fechas_entrega_documentacion()[1] . ' (lunes a viernes de 9 a 20 hs).</p>
    <p>Ante cualquier inquietud, no dudes en comunicarte con nosotros a través de nuestra web o respondiendo este correo electrónico.</p>
    <br><br>
    <p>Ante cualquier inquietud, no dudes en comunicarte con nosotros a través de nuestra web o respondiendo este correo electrónico.</p>
    <p>Atentamente,</p>
    <p>Departamento de Alumnos</p>
    <p>Instituto Nacional Superior del Profesorado Técnico</p>';
}

function mensaje_rechazo_formulario_incompleto_formulario($documentacion_faltante)
{
    $mensaje = '<p>El formulario de inscripción ya fue completado</p><p>Entregar los documentos faltantes para finalizar la inscripción:</p><ul>';
    foreach ($documentacion_faltante as $doc) {
        $mensaje .= '<li><p>' . $doc . '</p></li>';
    }
    $mensaje .= '</ul>' . '<p>Fechas para entrega de documentación para inscribirse:</p><p>Del ' . obtener_fechas_entrega_documentacion()[0] . ' al ' . obtener_fechas_entrega_documentacion()[1] . ' (lunes a viernes de 9 a 20 hs).</p>';
    return $mensaje;
}

function mensaje_rechazo_formulario_completado_formulario()
{
    return '<p>Este formulario ya está completado y <b>ya estás inscripto a la carrera</b></p>';
}

function validar_datos_formulario_preinscriptos($datos, $prefijo)
{
    $errores = [];
    $obligatorios = obtener_obligatorios((obtener_totalidad_campos_formulario_preinscripcion()), $prefijo);

    foreach ($obligatorios as $campo => $etiqueta) {
        if (empty($datos[$campo])) {
            $errores[] = 'El campo "' . $etiqueta . '" es obligatorio';
        }
    }

    if (!preg_match('/^\d{1,3}(?:\.\d{3})*$/', $datos[$prefijo . '_dni'])) {
        $errores[] = "Formato incorrecto. Se ingresa el DNI. Exclusivamente números separados por punto cada tres caracteres de derecha a izquierda.";
    }

    // Validar celular argentino
    $campo_celular = $prefijo . '_tel_movil';
    if (!empty($datos[$campo_celular]) && !is_array($datos[$campo_celular])) {
        $celular_limpio = preg_replace('/[^+\d]/', '', $datos[$campo_celular]);
        $regex_celular = '/^(\+54|0054)?(9)?(11|2\d|3\d|4\d|5\d|6\d|7\d|8\d|9\d)\d{8}$/';

        if (!preg_match($regex_celular, $celular_limpio)) {
            $errores[] = "Formato de celular inválido. Ejemplos válidos: 
                          - 1123456789 (nacional)
                          - 91123456789 (con 9)
                          - +5491123456789 (internacional)";
        }
    } elseif (!empty($datos[$campo_celular]) && is_array($datos[$campo_celular]) && !empty($datos[$campo_celular][$prefijo . '_contacto_emergencia_tel_movil'])) {
        $celular_limpio = preg_replace('/[^+\d]/', '', $datos[$campo_celular][$prefijo . '_contacto_emergencia_tel_movil']);
        $regex_celular = '/^(\+54|0054)?(9)?(11|2\d|3\d|4\d|5\d|6\d|7\d|8\d|9\d)\d{8}$/';

        if (!preg_match($regex_celular, $celular_limpio)) {
            $errores[] = "Formato de celular de emrgencia inválido. Ejemplos válidos: 
                          - 1123456789 (nacional)
                          - 91123456789 (con 9)
                          - +5491123456789 (internacional)";
        }
    }

    foreach ($datos[$prefijo . '_mails_de_contacto'] as $mail) {
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "Correo de mails de contacto inválidos" . $mail;

            $errores[] = '<p> usuario@.com (dominio inválido) </p>';

            $errores[] = '<p> @example.com (falta la parte local) </p>';

            $errores[] = '<p> usuario@dominio (falta el TLD, como .com) </p>';

            $errores[] = '<p> usuario espacio@example.com (espacios no permitidos). </p>';
        }
    }

    if (!empty($datos[$prefijo . '_mails_de_emergencia'][0])) {
        foreach ($datos[$prefijo . '_mails_de_emergencia'] as $mail) {
            if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                $errores[] = "Correo de mails de emergencia inválidos" . $mail;

                $errores[] = '<p> usuario@.com (dominio inválido) </p>';

                $errores[] = '<p> @example.com (falta la parte local) </p>';

                $errores[] = '<p> usuario@dominio (falta el TLD, como .com) </p>';

                $errores[] = '<p> usuario espacio@example.com (espacios no permitidos). </p>';
            }
        }
    }
    return $errores;
}

function sanitizar_datos_formulario_preinscriptos($datos, $prefijo)
{
    $dato_szanitizado = [];
    foreach ($datos as $key => $dato) {
        $fecha = is_string($dato) ? DateTime::createFromFormat('Y-m-d', $dato) : '';
        if ($key == $prefijo . '_apellidos' || $key == $prefijo . '_nombres' || $key == $prefijo . '_apellido_padre' || $key == $prefijo . '_nombre_padre' || $key == $prefijo . '_apellido_madre' || $key == $prefijo . '_nombre_madre') {
            $dato_szanitizado[$key] = implode(" ", array_map(function ($x) {
                return ucfirst(strtolower($x));
            }, explode(" ", $dato)));
        } elseif ($fecha) { // Ejemplo para campos de fecha
            $dato_szanitizado[$key] = $fecha->format('d/m/Y');
        } else {
            $dato_szanitizado[$key] = $dato;
        }
    }

    return $dato_szanitizado;
}