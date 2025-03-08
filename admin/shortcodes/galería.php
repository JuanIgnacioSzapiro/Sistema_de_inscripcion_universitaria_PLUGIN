<?php
function generador_de_galeria($atts)
{
    $atts = shortcode_atts(
        array(
            'post_type' => 'post'
        ),
        $atts,
        'mostrar_galeria'
    );

    if (!post_type_exists($atts['post_type'])) {
        return '<div class="error">Error: El post type "' . esc_html($atts['post_type']) . '" no existe.</div>';
    }

    $tipos = get_posts(array(
        'post_type' => 'tipos_de_carrera',
        'post_status' => 'publish',
        'numberposts' => -1,
        'order' => 'ASC'
    ));

    ob_start();

    if (!empty($tipos)) {
        foreach ($tipos as $tipo) {
            $tipo_id = $tipo->ID;
            $tipo_title = get_the_title($tipo);
            $tipo_descripcion = get_post_meta($tipo_id, 'INSPT_SISTEMA_DE_INSCRIPCIONES_tipos_de_carrera_descripcion_tipo_de_carrera', true);
            ?>
            <section class="tipo-carrera">
                <div class="titulos-y-subtitulos">
                    <h1 class="tipo-titulo"><?php echo esc_html($tipo_title); ?></h1>
                    <?php if (!empty($tipo_descripcion)): ?>
                        <h2 class="tipo-descripcion"><?php echo wp_kses_post($tipo_descripcion); ?></h2>
                    <?php endif; ?>
                </div>
                <?php
                $posts = get_posts(array(
                    'post_type' => $atts['post_type'],
                    'posts_per_page' => -1,
                    'post_status' => 'publish',
                    'meta_query' => array(
                        array(
                            'key' => 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_tipos_de_carrera',
                            'value' => $tipo_id,
                            'compare' => '='
                        )
                    ),
                    'order' => 'ASC'
                ));

                if (!empty($posts)):
                    if (count($posts) == 1) {
                        ?>
                        <div class="galeria-grid-sin-gap">
                            <?php
                    } else {
                        ?>
                            <div class="galeria-grid">
                                <?php
                    }
                    ?>
                            <?php foreach ($posts as $post):
                                setup_postdata($post);
                                $plan = get_post_meta($post->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_numero_de_plan_de_la_carrera', true);
                                $imagen_id = get_post_meta($post->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_imagen_para_galeria', true);
                                $descripcion = get_post_meta($post->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_descripcion_corta_de_la_carrera', true);
                                $imagen_url = $imagen_id ? wp_get_attachment_image_url($imagen_id, 'medium') : '';
                                $link = get_permalink($post->ID);
                                ?>
                                <article class="galeria-item">
                                    <a class="galeria-enlace" href="<?php echo esc_url($link); ?>">
                                        <?php if ($imagen_url): ?>
                                            <img src="<?php echo esc_url($imagen_url); ?>" alt="<?php echo esc_attr(get_the_title($post)); ?>"
                                                class="galeria-imagen">
                                            <div class="plan-de-carrera">Nro. de plan: <?php echo esc_attr($plan); ?></div>
                                        <?php else: ?>
                                            <div class="galeria-imagen-placeholder">Sin imagen</div>
                                        <?php endif; ?>
                                        <div class="galeria-texto">
                                            <h3 class="item-titulo"><?php echo esc_html(get_the_title($post)); ?></h3>
                                            <?php if (!empty($descripcion)): ?>
                                                <div class="item-descripcion"><?php echo wp_kses_post($descripcion); ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </a>
                                </article>
                            <?php endforeach;
                            wp_reset_postdata(); ?>
                        </div>
                    <?php else: ?>
                        <p class="sin-elementos">No se encontraron elementos para este tipo.</p>
                    <?php endif; ?>
            </section>
            <script>
            </script>
            <?php
        }
    } else {
        ?>
        <p class="sin-tipos">No se encontraron tipos de carrera.</p>
        <?php
    }

    return ob_get_clean();
}

add_shortcode('mostrar_galeria', 'generador_de_galeria');