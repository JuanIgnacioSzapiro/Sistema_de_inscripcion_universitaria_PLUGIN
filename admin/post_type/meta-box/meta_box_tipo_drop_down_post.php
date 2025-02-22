<?php //meta_box_tipo_drop_down_post.php
class CampoDropDownTipoPost extends TipoMetaBox
{
    private static $js_added = false;

    public function __construct(
        $nombre_meta,
        $etiqueta,
        $post_type_buscado,
        $descripcion,
        $clonable = false
    ) {
        $this->set_nombre_meta($nombre_meta);
        $this->set_etiqueta($etiqueta);
        $this->set_post_type_buscado($post_type_buscado);
        $this->set_descripcion($descripcion);
        $this->set_clonable($clonable);
    }

    public function generar_fragmento_html($post, $llave_meta)
    {
        $meta_key = $llave_meta . '_' . $this->get_nombre_meta();
        $selected_value = get_post_meta($post->ID, $meta_key, true);

        $args = array(
            'post_type' => $this->get_post_type_buscado(),
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'title',
            'order' => 'ASC'
        );
        $posts = get_posts($args);
        ?>
        <div class="campo-dropdown-container">
            <label for="<?php echo esc_attr($meta_key); ?>">
                <?php echo esc_html($this->get_etiqueta()); ?>
            </label>
            <br>
            <input id="buscador_<?php echo esc_attr($meta_key); ?>" type="text" placeholder="Buscador"
                class="buscador-dropdown">
            <select name="<?php echo esc_attr($meta_key); ?>" id="<?php echo esc_attr($meta_key); ?>">
                <option value="">Seleccionar...</option>
                <?php foreach ($posts as $post_option): ?>
                    <option value="<?php echo esc_attr($post_option->ID); ?>" <?php selected($selected_value, $post_option->ID); ?>>
                        <?php echo esc_html($post_option->post_title); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <p class="description">
                <?php echo esc_html($this->get_descripcion()); ?>
            </p>
        </div>
        <?php

        // Añadir script solo una vez
        if (!self::$js_added) {
            ?>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    document.querySelectorAll('.buscador-dropdown').forEach(function (buscador) {
                        buscador.addEventListener('input', function (e) {
                            const searchText = e.target.value.toLowerCase();
                            const container = e.target.closest('.campo-dropdown-container');
                            const select = container.querySelector('select');
                            Array.from(select.options).forEach(option => {
                                const text = option.textContent.toLowerCase();
                                if (text.includes(searchText) || option.value === '') {
                                    option.style.display = '';
                                } else {
                                    option.style.display = 'none';
                                }
                            });
                        });
                    });
                });
            </script>
            <?php
            self::$js_added = true;
        }
    }
}