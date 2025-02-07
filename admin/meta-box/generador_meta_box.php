<?php
class TipoMetaBox
{
    protected $texto = 'texto';
    protected $prefijo = 'INSPT_SISTEMA_DE_INSCRIPCIONES_';
    protected $post_type_de_origen; //post_type al que pertenece
    protected $titulo;
    protected $nombre_meta;
    protected $tipo_meta_data;
    protected $etiqueta;
    protected $texto_de_ejemplificacion;
    protected $descripcion;

    public function __construct()
    {
    }

    public function asignar_valores_tipo_texto(
        $post_type_de_origen,
        $titulo,
        $nombre_meta,
        $etiqueta,
        $texto_de_ejemplificacion,
        $descripcion
    ) {
        $this->set_post_type_de_origen($post_type_de_origen);
        $this->set_titulo($titulo);
        $this->set_nombre_meta($nombre_meta);
        $this->set_tipo_meta_data($this->texto);
        $this->set_etiqueta($etiqueta);
        $this->set_texto_de_ejemplificacion($texto_de_ejemplificacion);
        $this->set_descripcion($descripcion);
    }

    public function set_post_type_de_origen($post_type_de_origen)
    {
        $this->post_type_de_origen = $post_type_de_origen;
    }

    public function set_titulo($titulo)
    {
        $this->titulo = $titulo;
    }

    public function set_nombre_meta($nombre_meta)
    {
        $this->nombre_meta = $nombre_meta;
    }

    public function set_tipo_meta_data($tipo_meta_data)
    {
        $this->tipo_meta_data = $tipo_meta_data;
    }
    public function set_etiqueta($etiqueta)
    {
        $this->etiqueta = $etiqueta;
    }
    public function set_texto_de_ejemplificacion($texto_de_ejemplificacion)
    {
        $this->texto_de_ejemplificacion = $texto_de_ejemplificacion;
    }
    public function set_descripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function get_llave_meta()
    {
        return $this->prefijo . $this->get_post_type_de_origen() . '_' . $this->get_nombre_meta();
    }

    public function get_post_type_de_origen()
    {
        return $this->post_type_de_origen;
    }

    public function get_titulo()
    {
        return $this->titulo;
    }

    public function get_nombre_meta()
    {
        return (string) $this->nombre_meta;
    }

    public function get_tipo_meta_data()
    {
        return $this->tipo_meta_data;
    }
    public function get_etiqueta()
    {
        return $this->etiqueta;
    }
    public function get_texto_de_ejemplificacion()
    {
        return $this->texto_de_ejemplificacion;
    }
    public function get_descripcion()
    {
        return $this->descripcion;
    }

    public function crear_tipo_meta_box()
    {
        switch ($this->get_tipo_meta_data()) {
            case $this->texto:
                add_action('add_meta_boxes', array($this, 'crear_metadata'));
                add_action('save_post', array($this, 'guardar_tipo_texto'));
                break;
        }
    }

    public function crear_metadata()
    {
        add_meta_box($this->get_llave_meta(), $this->get_titulo(), array($this, 'mostrar_tipo_texto'), $this->get_post_type_de_origen());
    }

    public function mostrar_tipo_texto($post)
    {
        $custom_field_value = get_post_meta($post->ID, $this->get_llave_meta(), true);
        $nombre_meta = esc_attr($this->get_nombre_meta());
        $llave_meta = esc_attr($this->get_llave_meta());

        wp_nonce_field($llave_meta . '_nonce', $llave_meta . '_nonce');
        ?>
        <div class="meta-box">
            <label for="<?php echo $nombre_meta; ?>">
                <?php echo esc_html($this->get_etiqueta()); ?>
            </label>
            <input type="text" id="<?php echo $nombre_meta; ?>" name="<?php echo $nombre_meta; ?>"
                value="<?php echo esc_attr($custom_field_value); ?>" style="width: 100%;"
                placeholder="<?php echo esc_attr($this->get_texto_de_ejemplificacion()); ?>" />
            <p class="description">
                <?php echo esc_html($this->get_descripcion()); ?>
            </p>
        </div>
        <?php
    }

    public function guardar_tipo_texto($post_id)
    {
        // Check if nonce is set and valid
        if (!isset($_POST['custom_meta_box_nonce']) || !wp_verify_nonce($_POST['custom_meta_box_nonce'], 'custom_meta_box_nonce')) {
            return;
        }

        // Check if the current user has permission to edit the post
        if (!current_user_can('edit_' . $this->get_nombre_meta(), $post_id)) {
            return;
        }

        // Save the custom field data
        if (isset($_POST[$this->get_nombre_meta()])) {
            update_post_meta(
                $post_id,
                $this->get_llave_meta(), // Meta key
                sanitize_text_field($_POST[$this->get_nombre_meta()]) // Sanitized value
            );
        }
    }

}