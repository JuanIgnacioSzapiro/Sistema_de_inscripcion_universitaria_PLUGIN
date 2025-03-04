<?php

function generador_de_galeria($atts) {
    // Configurar atributos predeterminados
    $atts = shortcode_atts(
        array(
            'post_type' => 'post' // Valor por defecto
        ),
        $atts,
        'mostrar_galeria'
    );

    // Verificar si el post type existe
    if (!post_type_exists($atts['post_type'])) {
        return '<pre>Error: El post type "' . esc_html($atts['post_type']) . '" no existe.</pre>';
    }

    // Obtener los posts
    $posts = get_posts(array(
        'post_type' => $atts['post_type'],
        'posts_per_page' => -1 // Todos los posts
    ));

    // Generar HTML
    ob_start(); // Iniciar buffer de salida
    ?>
    <div class="galeria">
        <?php if (!empty($posts)) : ?>
            <ul>
                <?php foreach ($posts as $post) : ?>
                    <li>
                        <a href="<?php echo esc_url(get_permalink($post)); ?>">
                            <?php echo esc_html($post->post_title); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p>No se encontraron elementos.</p>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean(); // Devolver contenido del buffer
}

add_shortcode('mostrar_galeria', 'generador_de_galeria');