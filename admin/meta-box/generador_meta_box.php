<?php // generador_meta_box.php

class TipoMetaBox
{
    protected $prefijo = 'INSPT_SISTEMA_DE_INSCRIPCIONES_';
    protected $post_type_de_origen; //post_type al que pertenece
    protected $titulo;
    protected $contenido;
    protected $nombre_meta;
    protected $etiqueta;
    protected $texto_de_ejemplificacion;
    protected $descripcion;

    protected $post_type_buscado;

    public function __construct($post_type_de_origen, $titulo, $contenido)
    {
        $this->set_post_type_de_origen($post_type_de_origen);
        $this->set_titulo($titulo);
        $this->set_contenido($contenido);
    }

    public function set_post_type_de_origen($post_type_de_origen)
    {
        $this->post_type_de_origen = $post_type_de_origen;
    }

    public function set_titulo($titulo)
    {
        $this->titulo = $titulo;
    }
    public function set_contenido($contenido)
    {
        $this->contenido = $contenido;
    }

    public function set_nombre_meta($nombre_meta)
    {
        $this->nombre_meta = $nombre_meta;
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
    public function set_post_type_buscado($post_type_buscado)
    {
        $this->post_type_buscado = $post_type_buscado;
    }

    public function get_contenido()
    {
        return $this->contenido;
    }

    public function get_llave_meta()
    {
        return $this->prefijo . $this->get_post_type_de_origen();
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
    public function get_post_type_buscado()
    {
        return $this->post_type_buscado;
    }

    public function crear_tipo_meta_box()
    {
        add_action('add_meta_boxes', array($this, 'crear_metadata'));
        add_action('save_post', array($this, 'guardar'));
    }

    public function crear_metadata()
    {
        add_meta_box($this->get_llave_meta(), $this->get_titulo(), array($this, 'mostrar'), $this->get_post_type_de_origen());
    }

    public function mostrar($post)
    {
        $llave_meta = esc_attr($this->get_llave_meta());

        wp_nonce_field($llave_meta, $llave_meta);
        ?>
        <div class="meta-box">
            <?php
            foreach ($this->contenido as $individual) {
                $individual->generar_fragmento_html($post, $this->get_llave_meta());
            }
            ?>
        </div>
        <?php
    }

    public function guardar($post_id)
    {
        $nonce_name = $this->get_llave_meta();

        if (!wp_verify_nonce($_POST[$nonce_name], $nonce_name))
            return;

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return;

        if (!current_user_can('edit_' . $this->get_post_type_de_origen(), $post_id))
            return;

        foreach ($this->contenido as $individual) {
            $meta_key = $this->get_llave_meta() . '_' . $individual->get_nombre_meta();

            if ($individual instanceof MetaBoxTipoTextoClonable) {
                // Manejar campos clonables
                $valores = isset($_POST[$meta_key]) ? (array) $_POST[$meta_key] : array();
                $valores = array_map('sanitize_text_field', $valores);
                $valores = array_filter($valores, function ($valor) {
                    return !empty(trim($valor));
                });

                // Eliminar valores existentes
                delete_post_meta($post_id, $meta_key);

                // Añadir nuevos valores filtrados
                foreach ($valores as $valor) {
                    add_post_meta($post_id, $meta_key, $valor);
                }
            } elseif ($individual instanceof MetaBoxTipoDopDownPostType) {
                // Manejar dropdown de posts
                $valor = isset($_POST[$meta_key]) ? (int) $_POST[$meta_key] : 0;
                if ($valor > 0) {
                    update_post_meta($post_id, $meta_key, $valor);
                } else {
                    delete_post_meta($post_id, $meta_key);
                }
            } else {
                // Manejar campo simple
                $valor = isset($_POST[$meta_key]) ? sanitize_text_field($_POST[$meta_key]) : '';

                if (!empty(trim($valor))) {
                    update_post_meta($post_id, $meta_key, $valor);

                    // Actualizar título del post si es el campo nombre_de_la_carrera
                    if ($individual->get_nombre_meta() === 'nombre_de_la_carrera') {
                        remove_action('save_post', array($this, 'guardar'));
                        wp_update_post(array(
                            'ID' => $post_id,
                            'post_title' => $valor,
                            'post_name' => sanitize_title($valor)
                        ));
                        add_action('save_post', array($this, 'guardar'));
                    }
                } else {
                    delete_post_meta($post_id, $meta_key);
                }
            }
        }
    }
}