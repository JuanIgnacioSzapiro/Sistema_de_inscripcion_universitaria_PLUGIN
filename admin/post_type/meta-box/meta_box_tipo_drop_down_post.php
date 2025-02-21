<?php //meta_box_tipo_drop_down_post.php
<<<<<<< HEAD
class CampoDropDownTipoPost extends TipoMetaBox
=======
class MetaBoxTipoDropDownPostType extends TipoMetaBox
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
{
    public function __construct(
        $nombre_meta,
        $etiqueta,
        $post_type_buscado,
<<<<<<< HEAD
        $descripcion,
        $clonable = false
=======
        $descripcion
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
    ) {
        $this->set_nombre_meta($nombre_meta);
        $this->set_etiqueta($etiqueta);
        $this->set_post_type_buscado($post_type_buscado);
        $this->set_descripcion($descripcion);
<<<<<<< HEAD
        $this->set_clonable($clonable);
=======
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
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
        <div>
            <label for="<?php echo esc_attr($meta_key); ?>">
                <?php echo esc_html($this->get_etiqueta()); ?>
            </label>
<<<<<<< HEAD
            <br>
            <select name="<?php echo esc_attr($meta_key); ?>" id="<?php echo esc_attr($meta_key); ?>">
=======
            <select name="<?php $meta_key ?>" id="<?php $meta_key ?>">
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
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
    }
}