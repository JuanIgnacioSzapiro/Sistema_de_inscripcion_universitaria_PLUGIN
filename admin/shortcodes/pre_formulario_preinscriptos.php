<?php
require_once dirname(__FILE__) . '/../funciones.php';

// En tu archivo functions.php o en un plugin personalizado
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
            'Se selecciona las carrera, previamente creada y publicada',
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

            foreach (obtener_preguntas() as $pregunta) {
                ?>
                <div class="en-meta-box">
                    <?php
                    $pregunta->generar_fragmento_html_formulario(obtener_prefijo());
                    ?>
                </div>
                <?php
            }
            ?>
            <button type="submit" class="button">Iniciar preinscripción</button>
        </form>
        <div id="mensaje"></div>
    </div>
    <script>
        jQuery(document).ready(function ($) {
            $('#pre_formulario_preinscriptos_shortcode').submit(function (e) {
                e.preventDefault();

                var form = $(this);
                var nonce = $('#_wpnonce').val(); // Obtener el valor del nonce

                var mensaje_error = document.getElementById('mensaje');

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
                        mensaje_error.innerHTML = 'Errores: ' + xhr.responseText;
                    }
                });
            });
        });
    </script>
    <?php
    return ob_get_clean();
}

function obtener_obligatorios()
{
    $obligatorio = [];
    foreach (obtener_preguntas() as $pregunta) {
        if (!$pregunta->get_es_campo_opcional()) {
            $obligatorio += array(obtener_prefijo() . '_' . $pregunta->get_nombre_meta() => $pregunta->get_etiqueta());
        }
    }
    return $obligatorio;
}

function obtener_prefijo()
{
    return $GLOBALS['prefijo_variables_sql'] . '_form_ingreso';
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

    $errores = validar_datos($datos);

    if (!empty($errores)) {
        return new WP_REST_Response([
            'success' => false,
            'message' => $errores,
            'data' => $datos
        ], 200);
    } else {
        $datos_sanitizados = sanitizar_datos($datos);

        wp_set_current_user(1);

        $nuevo_formulario = array(
            'post_title' => $datos_sanitizados['INSPT_SISTEMA_DE_INSCRIPCIONES_form_ingreso_dni'] . ' - ' . $datos_sanitizados['INSPT_SISTEMA_DE_INSCRIPCIONES_form_ingreso_apellidos'],
            'post_status' => 'draft',
            'post_type' => 'form_ingreso',
            'post_author' => 1 // Forzar autoría
        );

        $post_id = wp_insert_post($nuevo_formulario);

        foreach ($datos_sanitizados as $key => $dato) {
            actualizar_data($post_id, $key, $dato);
        }

        // Opcional: Restaurar usuario original si es necesario
        wp_set_current_user(get_current_user_id());

        enviar_mail($datos_sanitizados['INSPT_SISTEMA_DE_INSCRIPCIONES_form_ingreso_mails_de_contacto'], $datos_sanitizados['INSPT_SISTEMA_DE_INSCRIPCIONES_form_ingreso_carreras']);

        return new WP_REST_Response([
            'success' => true,
            'message' => repuesta_succes(),
            'data' => $datos_sanitizados
        ], 200);
    }
}

function validar_datos($datos)
{
    $errores = [];
    $obligatorios = obtener_obligatorios();

    foreach ($obligatorios as $campo => $etiqueta) {
        if (empty($datos[$campo])) {
            $errores[] = 'El campo "' . $etiqueta . '" es obligatorio';
        }
    }

    if (!preg_match('/^\d{1,3}(?:\.\d{3})*$/', $datos['INSPT_SISTEMA_DE_INSCRIPCIONES_form_ingreso_dni'])) {
        $errores[] = "Formato incorrecto. Se ingresa el DNI. Exclusivamente números separados por punto cada tres caracteres de derecha a izquierda.";
    }

    foreach ($datos['INSPT_SISTEMA_DE_INSCRIPCIONES_form_ingreso_mails_de_contacto'] as $mail) {
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

function repuesta_succes()
{
    return array(
        'Se ha iniciado el trámite de tu preinscripción. Personal del Departamento de Alumnos (ingreso2025@inspt.utn.edu.ar) se pondrá en contacto para finalizar con el trámite de preinscripción.',
        '<b>IMPORTANTE:</b> La preinscripción será procesada una vez que hayas, presentando la documentación requerida en la sede dentro de los plazos establecidos por el INSPT.'
    );
}

function sanitizar_datos($datos)
{
    $dato_szanitizado = [];
    foreach ($datos as $key => $dato) {
        if ($key == 'INSPT_SISTEMA_DE_INSCRIPCIONES_form_ingreso_apellidos' || $key == 'INSPT_SISTEMA_DE_INSCRIPCIONES_form_ingreso_nombres') {
            $dato_szanitizado[$key] = implode(" ", array_map(function ($x) {
                return ucfirst(strtolower($x));
            }, explode(" ", $dato)));
        } else {
            $dato_szanitizado[$key] = $dato;
        }
    }
    return $dato_szanitizado;
}

function actualizar_data($post_id, $key, $dato)
{
    if (!is_wp_error($post_id)) {
        if (is_array($dato)) {
            foreach ($dato as $fragmento) {
                add_post_meta($post_id, $key, $fragmento);
            }
        } else {
            update_post_meta($post_id, $key, $dato);
        }
    } else {
        return "Error al crear formulario: " . $post_id->get_error_message();
    }
}
function enviar_mail($mails, $carrera)
{
    foreach ($mails as $mail) {
        $mailer = new Mailing($mail, 'INSPT - Inscripción a ' . get_the_title($carrera), mensaje());
        $mailer->mandar_mail();
    }
}

function mensaje()
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
    <p>Bienvenida/o nuevamente.</p>
    <p>Te enviamos este correo para que puedas continuar con el proceso de preinscripción a las carreras del INSPT-UTN.</p>
    <p>Es necesario que conserves este mensaje hasta finalizar el trámite.</p>
    <br>
    <p>Protocolo de inscripción</p>
    <p><b>1. Preinscripción a las carreras del INSPT-UTN vía el formulario "Continuar Preinscripción”</b></p>
    <p>Completa todos los campos solicitados en el siguiente formulario. Verifica que los mismos sean correctos antes del envío, en especial, Nombre y Apellido, DNI y mail.</p>
    <p>Puedes acceder por aquí</p>
    <a class="button" href="' . obtener_el_link_formulario() . '">Continuar Preinscripción</a>
    <p> o bien, pega la siguiente url en tu navegador:</p>
    <p></p>
    <p>En caso de no completarlo ahora, podrás reutilizar el link cuantas veces sea necesario, los valores ya ingresados serán guardados en la medida que los vayas cargando.</p>
    <p><b>IMPORTANTE:</b></p>
    <p><b>2. Presentación de la documentación</b></p>
    <p>La vacante quedará reservada una vez que hayas completado el formulario “continuar Preinscripción” y <b>presentado en nuestra sede de Av. Triunvirato 3174, CABA, de 9 a 20 hs. toda la documentación requerida dentro de los plazos fijados por el INSPT.</b></p>
    <a class="button" href="' . obtener_el_link_documentacion() . '">Documentación requerida</a>
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
