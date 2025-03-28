<?php
// Redirección temprana para usuarios no autenticados
add_action('template_redirect', 'controlar_acceso_pagina_con_shortcode');

function controlar_acceso_pagina_con_shortcode()
{
    global $post;

    // Verificar si es página y contiene el shortcode
    if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'menu_de_inicio')) {
        if (!is_user_logged_in()) {
            $url_login = obtener_resultado_query("SELECT guid FROM wp_posts WHERE wp_posts.ID = (SELECT meta_value FROM wp_postmeta WHERE meta_key like '" . $GLOBALS['prefijo_variables_sql'] . '_links_inicio_sesion' . "')")[0]->guid;
            wp_safe_redirect($url_login);
            exit;
        }
    }
}