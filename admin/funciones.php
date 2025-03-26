<?php
function obtener_el_link_de_pagina($key_de_array_asociado)
{
    return get_post(get_post_meta(get_posts(
        array(
            'numberposts' => 1,
            'post_type' => 'links_preinscriptos',
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'ASC'
        )
    )[0]->ID, $key_de_array_asociado, true))->guid;
}

function obtener_resultado_query($query)
{
    global $wpdb;

    // Es buena práctica usar prepare() para evitar inyecciones SQL
    return $wpdb->get_results($query);
}

function obtener_prefijo($prefijo_post_type)
{
    return $GLOBALS['prefijo_variables_sql'] . $prefijo_post_type;
}

function espiar($texto, $data)
{
    error_log($texto . ': ' . print_r($data, true));
    return $data;
}

function obtener_obligatorios($preguntas, $prefijo)
{
    $obligatorio = [];
    foreach ($preguntas as $pregunta) {
        if (!$pregunta->get_es_campo_opcional()) {
            $obligatorio += array($prefijo . '_' . $pregunta->get_nombre_meta() => $pregunta->get_etiqueta());
        }
    }
    return $obligatorio;
}

function actualizar_data($post_id, $key, $dato)
{
    if (!is_wp_error($post_id)) {
        if (is_array($dato)) {
            foreach ($dato as $fragmento) {
                if (is_array($fragmento)) {
                    add_post_meta($post_id, $key, json_encode($dato));
                } else {
                    add_post_meta($post_id, $key, $fragmento);
                }
            }
        } else {
            update_post_meta($post_id, $key, $dato);
        }
    } else {
        return "Error al crear formulario: " . $post_id->get_error_message();
    }
}

function enviar_mail($mails, $carrera, $mensaje)
{
    foreach ($mails as $mail) {
        $mailer = new Mailing($mail, 'INSPT - Inscripción a ' . get_the_title($carrera), $mensaje);
        $mailer->mandar_mail();
    }
}

function recorrer_array($campos, $prefijo)
{
    foreach ($campos as $campo) {
        ?>
        <div class="en-meta-box">
            <?php
            $campo->generar_fragmento_html_formulario($prefijo);
            ?>
        </div>
        <?php
    }
}

function obtener_fecha_inscripciones_valida()
{
    $query_fecha = "SELECT meta_value from wp_postmeta WHERE wp_postmeta.post_id = (SELECT ID from wp_posts WHERE wp_posts.post_type like 'fechas' and wp_posts.post_status like 'publish' ORDER BY wp_posts.ID DESC limit 1) and wp_postmeta.meta_key like '";

    $fecha_de_inscripcion_apertura = obtener_resultado_query($query_fecha . "INSPT_SISTEMA_DE_INSCRIPCIONES_fechas_apertura_apertura_de_inscripciones';")[0]->meta_value;

    $fecha_de_inscripcion_cierre = obtener_resultado_query($query_fecha . "INSPT_SISTEMA_DE_INSCRIPCIONES_fechas_cierre_de_inscripciones';")[0]->meta_value;

    if (date("d/m/y") <= $fecha_de_inscripcion_apertura && get_the_date() >= $fecha_de_inscripcion_cierre) {
        return $errores[] = '<p>La fecha de inscripción es desde ' . $fecha_de_inscripcion_apertura . ', hasta ' . $fecha_de_inscripcion_cierre . '</p>';
    } else {
        return '';
    }
}

function obtener_fechas_entrega_documentacion()
{
    $query_fecha = "SELECT meta_value from wp_postmeta WHERE wp_postmeta.post_id = (SELECT ID from wp_posts WHERE wp_posts.post_type like 'fechas' and wp_posts.post_status like 'publish' ORDER BY wp_posts.ID DESC limit 1) and wp_postmeta.meta_key like '";

    $fecha_de_inscripcion_apertura = obtener_resultado_query($query_fecha . "INSPT_SISTEMA_DE_INSCRIPCIONES_fechas_apertura_entrega_documentacion';")[0]->meta_value;

    $fecha_de_inscripcion_cierre = obtener_resultado_query($query_fecha . "INSPT_SISTEMA_DE_INSCRIPCIONES_fechas_cierre_documentacion';")[0]->meta_value;

    return array($fecha_de_inscripcion_apertura, $fecha_de_inscripcion_cierre);
}