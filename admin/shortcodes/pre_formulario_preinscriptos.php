<?php
require_once dirname(__FILE__) . '/../funciones.php';

function obtener_preguntas()
{
    return array(
        new CampoTexto(
            'dni',
            'DNI',
            '11.111.111',
            'Se ingresa el DNI. Exclusivamente números separados por punto cada tres caracteres de derecha a izquierda',
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
        new CampoDropDownTipoPost(
            'carreras',
            'Carreras a la que está inscripta',
            'carreras',
            'Se selecciona la carrera a la que se quiere inscribir',
        ),
    );
}
// 1. Crear el shortcode
add_shortcode('pre_formulario_preinscriptos', 'pre_formulario_preinscriptos_shortcode');
function pre_formulario_preinscriptos_shortcode()
{
    ob_start();
    wp_nonce_field('wp_rest');
    ?>
    <div id="ocultador"></div>
    <div class="formulario">
        <form id="pre_formulario_preinscriptos_shortcode">
            <h2>INGRESO 2025</h2>
            <p>Bienvenido/a al <b>INSPT-UTN</b></p>
            <p>A continuación, te brindamos Información sobre la <b>oferta académica del INSPT</b></p>
            <p>Ingresa a <a
                    href="http://localhost/wordpress/index.php/demostracion-shortcodes/">http://localhost/wordpress/index.php/demostracion-shortcodes/</a>
                y consulta la carrera de tu interés (turnos, planes de estudios, entre otros)</p>
            <b>Acerca de la Preinscripción a las carreras del INSPT - UTN</b>
            <p>• Completa los campos requeridos a continuación (asegúrate de ingresar correctamente el mail ya que allí
                recibirás información para continuar el trámite).</p>
            <p>• Sigue las instrucciones que recibas por correo electrónico. No olvides revisar la carpeta de SPAM. En caso
                de
                no recibirlo, no dudes en comunicarte con nosotros a ingreso2025@inspt.utn.edu.ar .</p>

            <?php
            recorrer_array(obtener_preguntas(), obtener_prefijo('_pre_form_ingreso'));
            ?>
            <button type="submit" class="button">Iniciar preinscripción</button>
        </form>
        <div id="mensaje"></div>
    </div>
    <script>
        jQuery(document).ready(function ($) {
            $('#pre_formulario_preinscriptos_shortcode').submit(function (e) {
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
                    url: '<?php echo esc_url(rest_url('pre_formulario_preinscriptos_shortcode/v1/submit')); ?>',
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
        'pre_formulario_preinscriptos_shortcode/v1',
        '/submit',
        array(
            'methods' => 'POST',
            'callback' => 'handle_pre_formulario_preinscriptos_shortcode_submit',
            'permission_callback' => '__return_true' // <- Esto es requerido en WordPress 5.5+
        )
    );
});

function handle_pre_formulario_preinscriptos_shortcode_submit($request)
{
    $prefijo = obtener_prefijo('_pre_form_ingreso');
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

    $errores = validar_datos_pre_formulario_preinscriptos($datos, $prefijo);

    if (!empty($errores)) {
        return new WP_REST_Response([
            'success' => false,
            'message' => $errores,
            'data' => $datos
        ], 200);
    } else {
        $datos_sanitizados = sanitizar_datos_pre_formulario_preinscriptos($datos, $prefijo);

        wp_set_current_user(1);

        $existe_pre_formulario = obtener_resultado_query("select post_id from wp_postmeta where wp_postmeta.post_id = (SELECT ID from wp_posts WHERE wp_posts.post_title like '" . $datos_sanitizados[$prefijo . '_dni'] . "%' and wp_posts.post_status like 'publish' and wp_posts.post_type like 'pre_form_ingreso') and wp_postmeta.meta_key like 'INSPT_SISTEMA_DE_INSCRIPCIONES_pre_form_ingreso_carreras' and wp_postmeta.meta_value = " . $datos_sanitizados[$prefijo . '_carreras']);

        $existe_formulario = !empty($existe_pre_formulario) ? obtener_resultado_query("SELECT ID from wp_posts WHERE wp_posts.post_title like '" . $datos_sanitizados[$prefijo . '_dni'] . "%' and wp_posts.post_type like 'form_ingreso'") : '';

        $estado_de_formulario = !empty($existe_formulario) ? obtener_resultado_query("SELECT post_status from wp_posts where wp_posts.ID = " . $existe_formulario[0]->ID)[0]->post_status : '';

        /*
        chequear existencia de pre formularios con ese dni
        false->seguimiento normal // redireccionamiento y se crea pre formulario
        true->chequear existencia de formularios por dni completado
            false->seguimiento normal // redireccionamiento y se crea pre formulario
            true->chequear si esos formularios son de esta misma carrera
                false->seguimiento normal // redireccionamiento y se crea pre formulario
                true->chequear si ese formulario está publicado
                    false->enviar mensaje con los documentos faltantes a entregar e informar que este formulario ya fue entregado
                    true->seguimiento normal. Generar un nuevo formulario porque va a volver a comenzar la carrera
        */

        if ($estado_de_formulario == 'publish') { // reinscripto en caso de que se haya vencido la anterior
            $nuevo_formulario = array(
                'post_title' => $datos_sanitizados[$prefijo . '_dni'] . ' - ' . $datos_sanitizados[$prefijo . '_apellidos'],
                'post_status' => 'publish', // Cambiado a publish para crear como publicado
                'post_type' => 'pre_form_ingreso',
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

            // Opcional: Restaurar usuario original si es necesario
            wp_set_current_user(get_current_user_id());

            enviar_mail($datos_sanitizados[$prefijo . '_mails_de_contacto'], $datos_sanitizados[$prefijo . '_carreras'], mensaje_rechazo_formulario_completado_pre_formulario() . '<p>En caso de haberse vencido la inscripción:</p>' . mensaje_aceptacion_pre_formulario($datos_sanitizados[$prefijo . '_apellidos'] . '; ' . $datos_sanitizados[$prefijo . '_nombres'], get_post($post_id)->guid));

            return new WP_REST_Response([
                'success' => false,
                'message' => ['<p><b>Únicamente terminar de completar el siguiente formulario en caso de haberse vencido la inscripción anterior</b>, revisar los mails.</p>', mensaje_rechazo_formulario_completado_pre_formulario()],
                'data' => $datos_sanitizados
            ], 200);
        } elseif ( // falta la entrega de documentación
            !empty($existe_pre_formulario)
            && !empty($existe_formulario)
            && $estado_de_formulario == 'draft'
        ) {
            $post_id = $existe_formulario[0]->ID;

            $documentacion_entregada = get_post_meta($post_id, 'INSPT_SISTEMA_DE_INSCRIPCIONES_form_ingreso_documentacion_entregada', true);

            $documentacion_a_entregar = array_map(function ($x) {
                return $x->post_title;
            }, obtener_resultado_query("SELECT post_title from wp_posts where wp_posts.ID IN (SELECT meta_value FROM wp_postmeta WHERE wp_postmeta.post_id = (SELECT ID FROM wp_posts WHERE post_title LIKE CONCAT( '%', (SELECT post_title FROM wp_posts INNER JOIN wp_postmeta on wp_posts.ID = (SELECT meta_value FROM wp_postmeta WHERE wp_postmeta.meta_key = 'INSPT_SISTEMA_DE_INSCRIPCIONES_form_ingreso_carreras' AND wp_postmeta.post_id = " . $post_id . ") limit 1), '%') and wp_posts.post_type = 'doc_total' and wp_posts.post_status like 'publish' ORDER BY wp_posts.post_date DESC LIMIT 1) AND wp_postmeta.meta_key like 'INSPT_SISTEMA_DE_INSCRIPCIONES_doc_total_doc') and wp_posts.post_status LIKE 'publish' ORDER by wp_posts.post_title ASC;"));

            $documentacion_faltante = array_diff($documentacion_a_entregar, !empty($documentacion_entregada) ? $documentacion_entregada : array());

            $mensaje_total = mensaje_rechazo_formulario_incompleto_pre_formulario($documentacion_faltante);

            enviar_mail($datos_sanitizados[$prefijo . '_mails_de_contacto'], $datos_sanitizados[$prefijo . '_carreras'], $mensaje_total);

            return new WP_REST_Response([
                'success' => false,
                'message' => [$mensaje_total],
                'data' => $datos_sanitizados
            ], 200);
        } elseif ( // ya existe el pre_formulario, pero no completó el formulario final
            !empty($existe_pre_formulario)
        ) {
            $post_id = $existe_pre_formulario[0]->post_id;

            // Verificar que se creó correctamente el post
            if ($post_id && !is_wp_error($post_id)) {
                // Guardar cada campo como metadato
                foreach ($datos_sanitizados as $key => $dato) {
                    actualizar_data($post_id, $key, $dato);
                }
            }

            // Opcional: Restaurar usuario original si es necesario
            wp_set_current_user(get_current_user_id());

            enviar_mail($datos_sanitizados[$prefijo . '_mails_de_contacto'], $datos_sanitizados[$prefijo . '_carreras'], mensaje_aceptacion_pre_formulario($datos_sanitizados[$prefijo . '_apellidos'] . '; ' . $datos_sanitizados[$prefijo . '_nombres'], get_post($post_id)->guid));

            return new WP_REST_Response([
                'success' => true,
                'message' => ['<p><b>IMPORTANTE:</b> Revisar los mails aportados para terminar la inscripción.</p>', repuesta_succes_pre_formulario()],
                'data' => $datos_sanitizados
            ], 200);
        } else {
            $nuevo_formulario = array(
                'post_title' => $datos_sanitizados[$prefijo . '_dni'] . ' - ' . $datos_sanitizados[$prefijo . '_apellidos'],
                'post_status' => 'publish', // Cambiado a publish para crear como publicado
                'post_type' => 'pre_form_ingreso',
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

            // Opcional: Restaurar usuario original si es necesario
            wp_set_current_user(get_current_user_id());

            enviar_mail($datos_sanitizados[$prefijo . '_mails_de_contacto'], $datos_sanitizados[$prefijo . '_carreras'], mensaje_aceptacion_pre_formulario($datos_sanitizados[$prefijo . '_apellidos'] . '; ' . $datos_sanitizados[$prefijo . '_nombres'], get_post($post_id)->guid));

            return new WP_REST_Response([
                'success' => true,
                'message' => [repuesta_succes_pre_formulario()],
                'data' => $datos_sanitizados
            ], 200);
        }
    }
}

function repuesta_succes_pre_formulario()
{
    return '<p>Se ha iniciado el trámite de tu preinscripción. Personal del Departamento de Alumnos (ingreso2025@inspt.utn.edu.ar) se pondrá en contacto para finalizar con el trámite de preinscripción.</p>' . '<p><b>IMPORTANTE:</b> La preinscripción será finalizada una vez que hayas terminado el formulario de preinscripción y presentando la documentación requerida en la sede dentro de los plazos establecidos por el INSPT.</p>';
}

function mensaje_aceptacion_pre_formulario($persona, $redireccionamiento)
{
    return '<style>
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 5px;
            background-color: #2980b9;
            color: white !important;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .button:hover {
            opacity: 0.9;
        }
    </style>
    <p>Bienvenida/o ' . $persona . '</p>
    <p>Te enviamos este correo para que puedas continuar con el proceso de preinscripción a las carreras del INSPT-UTN.</p>
    <p>Es necesario que conserves este mensaje hasta finalizar el trámite.</p>
    <br>
    <p>Protocolo de inscripción</p>
    <p><b>1. Preinscripción a las carreras del INSPT-UTN vía el formulario "Continuar Preinscripción”</b></p>
    <p>Completa todos los campos solicitados en el siguiente formulario. Verifica que los mismos sean correctos antes del envío, en especial, Nombre y Apellido, DNI y mail.</p>
    <p>Puedes acceder por aquí</p>
    <a class="button" href="' . $redireccionamiento . '">Continuar Preinscripción</a>
    <p> o bien, pega la siguiente url en tu navegador:</p>
    <p></p>
    <p>En caso de no completarlo ahora, podrás reutilizar el link cuantas veces sea necesario, los valores ya ingresados serán guardados en la medida que los vayas cargando.</p>
    <p><b>IMPORTANTE:</b></p>
    <p><b>2. Presentación de la documentación</b></p>
    <p>La vacante quedará reservada una vez que hayas completado el formulario “continuar Preinscripción” y <b>presentado en nuestra sede de Av. Triunvirato 3174, CABA, de 9 a 20 hs. toda la documentación requerida dentro de los plazos fijados por el INSPT.</b></p>
    <a class="button" href="' . obtener_el_link_de_pagina($GLOBALS['prefijo_variables_sql'] . '_links_preinscriptos_link_documentacion') . '">Documentación requerida</a>
    <b>
    <p>Fechas para entrega de documentación para inscribirse:</p>
    <p>Del 5/8/2024 al 13/12/2024 (lunes a viernes de 9 a 20 hs).</p>
    <p>IMPORTANTE: Revisar en la página web las condiciones de ingreso a cada carrera (ver "TIPO DE INGRESO"). Allí se detallan los plazos de entrega de documentación para acceder a los mismos.</p>
    </b>
    <br><br>
    <p>Ante cualquier inquietud, no dudes en comunicarte con nosotros a través de nuestra web o respondiendo este correo electrónico.</p>
    <p>Atentamente,</p>
    <p>Departamento de Alumnos</p>
    <p>Instituto Nacional Superior del Profesorado Técnico</p>';
}

function mensaje_rechazo_formulario_incompleto_pre_formulario($documentacion_faltante)
{
    $mensaje = '<p>Este formulario ya está completado.</p><p>Entregar los documentos faltantes para finalizar la inscripción:</p><ul>';
    foreach ($documentacion_faltante as $doc) {
        $mensaje .= '<li><p>' . $doc . '</p></li>';
    }
    $mensaje .= '</ul>';
    return $mensaje;
}

function mensaje_rechazo_formulario_completado_pre_formulario()
{
    return '<p>Este formulario ya está completado y <b>ya estás inscripto a la carrera</b></p>';
}

function validar_datos_pre_formulario_preinscriptos($datos, $prefijo)
{
    $errores = [];
    $obligatorios = obtener_obligatorios(obtener_preguntas(), $prefijo);

    foreach ($obligatorios as $campo => $etiqueta) {
        if (empty($datos[$campo])) {
            $errores[] = 'El campo "' . $etiqueta . '" es obligatorio';
        }
    }

    if (!preg_match('/^\d{1,3}(?:\.\d{3})*$/', ($datos)[$prefijo . '_dni'])) {
        $errores[] = "Formato incorrecto. Se ingresa el DNI. Exclusivamente números separados por punto cada tres caracteres de derecha a izquierda.";
    }

    foreach ($datos[$prefijo . '_mails_de_contacto'] as $mail) {
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "Correo inválido" . $mail;

            $errores[] = '<p> usuario@.com (dominio inválido) </p>';

            $errores[] = '<p> @example.com (falta la parte local) </p>';

            $errores[] = '<p> usuario@dominio (falta el TLD, como .com) </p>';

            $errores[] = '<p> usuario espacio@example.com (espacios no permitidos). </p>';
        }
    }

    return $errores;
}

function sanitizar_datos_pre_formulario_preinscriptos($datos, $prefijo)
{
    $dato_szanitizado = [];
    foreach ($datos as $key => $dato) {
        if ($key == $prefijo . '_apellidos' || $key == $prefijo . '_nombres') {
            $dato_szanitizado[$key] = implode(" ", array_map(function ($x) {
                return ucfirst(strtolower($x));
            }, explode(" ", $dato)));
        } else {
            $dato_szanitizado[$key] = $dato;
        }
    }
    return $dato_szanitizado;
}