<?php
class CampoDropDownPredeterminado extends TipoMetaBox
{
    public function __construct(
        $nombre_meta,
        $etiqueta,
        $opciones,
        $descripcion,
        $clonable = false,
        $es_campo_opcional = false,
    ) {
        $this->set_nombre_meta($nombre_meta);
        $this->set_etiqueta($etiqueta);
        $this->set_opciones($opciones);
        $this->set_descripcion($descripcion);
        $this->set_clonable($clonable);
        $this->set_es_campo_opcional($es_campo_opcional);
    }

    public function generar_fragmento_html($post, $llave_meta)
    {
        $meta_key = $llave_meta . '_' . $this->get_nombre_meta();
        $selected_value = get_post_meta($post->ID, $meta_key, true);

        $argumentos = $this->get_opciones();
        ?>
        <div>
            <label for="<?php echo esc_attr($meta_key); ?>">
                <?php echo esc_html($this->get_etiqueta()); ?>
            </label>
            <br>
            <select name="<?php echo esc_attr($meta_key); ?>" id="<?php echo esc_attr($meta_key); ?>">
                <option value="">Seleccionar...</option>
                <?php foreach ($argumentos as $opcion): ?>
                    <option value="<?php echo esc_attr($opcion); ?>" <?php selected($selected_value, $opcion); ?>>
                        <?php echo esc_html($opcion); ?>
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