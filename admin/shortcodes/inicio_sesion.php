<?php

function obtener_campos_inicio_sesion()
{
    return array(
        new CampoTexto(
            'nombre_o_correo',
            'Nombre de usuario o correo electrónico',
            '',
            '',
        ),
        new CampoClave(
            'clave',
            'Contraseña',
            '',
            '',
        ),
    );
}

add_shortcode('inicio_sesion_manejo_preinscriptos', 'inicio_sesion_shortcode');

function inicio_sesion_shortcode()
{
    ob_start();
    wp_nonce_field('wp_rest');
    ?>
    <div id="ocultador"></div>
    <div class="formulario">
        <form id="inicio_sesion_shortcode">
            <h2>Iniciar sesión</h2>

            <?php
            recorrer_array(obtener_campos_inicio_sesion(), obtener_prefijo(''));
            ?>
            <button type="submit" class="button">Iniciar sesión</button>
        </form>
        <div id="mensaje"></div>
    </div>
    <script>
        jQuery(document).ready(function ($) {
            $('#inicio_sesion_shortcode').submit(function (e) {
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
                    url: '<?php echo esc_url(rest_url('inicio_sesion_shortcode/v1/submit')); ?>',
                    data: form.serialize(),
                    dataType: 'json',
                    xhrFields: {
                        withCredentials: true
                    },
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
                            if (response.redirect) {
                                window.location.href = response.redirect;
                            }
                        } else {
                            mensaje_error.classList.add("mensaje-de-error");
                            response.message.forEach(element => {
                                mensaje_error.innerHTML += '<p>' + element + '</p>';
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
        'inicio_sesion_shortcode/v1',
        '/submit',
        array(
            'methods' => 'POST',
            'callback' => 'handle_inicio_sesion_shortcode_submit',
            'permission_callback' => '__return_true' // <- Esto es requerido en WordPress 5.5+
        )
    );
});

function handle_inicio_sesion_shortcode_submit($request)
{
    $errores = array(); // Inicializar array de errores
    $nonce = isset($_SERVER['HTTP_X_WP_NONCE']) ? sanitize_text_field($_SERVER['HTTP_X_WP_NONCE']) : '';

    if (!wp_verify_nonce($nonce, 'wp_rest')) {
        return new WP_REST_Response([
            'success' => false,
            'message' => ['Nonce de seguridad inválido']
        ], 403);
    }

    $datos = $request->get_params();
    $nombre_usuario_ingresado = sanitize_user($datos['INSPT_SISTEMA_DE_INSCRIPCIONES_nombre_o_correo']);
    $clave_ingresada = $datos['INSPT_SISTEMA_DE_INSCRIPCIONES_clave']; // Sin sanitización

    // Validar campos vacíos
    if (empty($nombre_usuario_ingresado)) {
        $errores[] = 'El nombre de usuario o correo es requerido';
    }
    if (empty($clave_ingresada)) {
        $errores[] = 'La contraseña es requerida';
    }

    if (!empty($errores)) {
        return new WP_REST_Response([
            'success' => false,
            'message' => $errores
        ], 200);
    }

    $user = wp_signon([
        'user_login' => $nombre_usuario_ingresado,
        'user_password' => $clave_ingresada,
        'remember' => true
    ], false);

    if (is_wp_error($user)) {
        $errores[] = 'Usuario o contraseña incorrectos';
        return new WP_REST_Response([
            'success' => false,
            'message' => $errores
        ], 200);
    }

    return new WP_REST_Response([
        'success' => true,
        'redirect' => obtener_resultado_query("SELECT guid FROM wp_posts WHERE wp_posts.ID = (SELECT meta_value FROM wp_postmeta WHERE meta_key like '" . $GLOBALS['prefijo_variables_sql'] . '_links_menu_inicio' . "')")[0]->guid,
        'message' => ['Inicio de sesión exitoso']
    ], 200);
}