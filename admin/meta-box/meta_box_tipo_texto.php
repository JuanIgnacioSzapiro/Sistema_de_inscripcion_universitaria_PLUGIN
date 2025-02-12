<?php // meta_box_tipo_texto.php
require_once dirname(__FILE__) . '/generador_meta_box.php';

class MetaBoxTipoTexto extends TipoMetaBox
{
    public function __construct(
        $nombre_meta,
        $etiqueta,
        $texto_de_ejemplificacion,
        $descripcion
    ) {
        $this->set_nombre_meta($nombre_meta);
        $this->set_etiqueta($etiqueta);
        $this->set_texto_de_ejemplificacion($texto_de_ejemplificacion);
        $this->set_descripcion($descripcion);
    }

    public function generar_fragmento_html($post, $llave)
    {
        $meta_llave = $llave . '_' . $this->get_nombre_meta();
        $custom_field_value = get_post_meta($post->ID, $meta_llave, true);
        ?>
        <label for="<?php echo esc_attr($meta_llave); ?>">
            <?php echo esc_html($this->get_etiqueta()); ?>
        </label>
        <input type="text" id="<?php echo esc_attr($meta_llave); ?>" name="<?php echo esc_attr($meta_llave); ?>"
            value="<?php echo esc_attr($custom_field_value); ?>"
            placeholder="<?php echo esc_attr($this->get_texto_de_ejemplificacion()); ?>" style="width: 100%;" />
        <p class="description">
            <?php echo esc_html($this->get_descripcion()); ?>
        </p>
        <?php
    }
}