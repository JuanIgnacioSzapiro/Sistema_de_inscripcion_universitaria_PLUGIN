<?php // generador_meta_box.php

class TipoMetaBox
{
<<<<<<< HEAD
    protected $prefijo = 'INSPT_SISTEMA_DE_INSCRIPCIONES';
    protected $post_type_de_origen; //post_type al que pertenece
    protected $titulo_de_editor;
=======
    protected $prefijo = 'INSPT_SISTEMA_DE_INSCRIPCIONES_';
    protected $post_type_de_origen; //post_type al que pertenece
    protected $titulo;
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
    protected $contenido;
    protected $nombre_meta;
    protected $etiqueta;
    protected $texto_de_ejemplificacion;
    protected $descripcion;
    protected $post_type_buscado;
<<<<<<< HEAD
    protected $tipo_de_archivo;
    protected $clonable;
    protected $opciones;
    protected $titulo;

    public function __construct($titulo_de_editor, $contenido, $titulo)
    {
        $this->set_titulo_de_editor($titulo_de_editor);
        $this->set_contenido($contenido);
        $this->set_titulo($titulo);
=======

    protected $tipo_de_archivo;

    public function __construct($titulo, $contenido)
    {
        $this->set_titulo($titulo);
        $this->set_contenido($contenido);
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e

        add_action('admin_notices', array($this, 'mostrar_errores'));
    }

    public function set_post_type_de_origen($post_type_de_origen)
    {
        $this->post_type_de_origen = $post_type_de_origen;
    }

<<<<<<< HEAD
    public function set_titulo_de_editor($titulo_de_editor)
    {
        $this->titulo_de_editor = $titulo_de_editor;
=======
    public function set_titulo($titulo)
    {
        $this->titulo = $titulo;
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
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

    public function set_tipo_de_archivo($tipo_de_archivo)
    {
        $this->tipo_de_archivo = $tipo_de_archivo;
    }

    public function get_contenido()
    {
        return $this->contenido;
    }

    public function get_llave_meta()
    {
<<<<<<< HEAD
        return $this->prefijo . '_' . $this->get_post_type_de_origen();
=======
        return $this->prefijo . $this->get_post_type_de_origen();
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
    }

    public function get_post_type_de_origen()
    {
        return $this->post_type_de_origen;
    }

<<<<<<< HEAD
    public function get_titulo_de_editor()
    {
        return $this->titulo_de_editor;
=======
    public function get_titulo()
    {
        return $this->titulo;
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
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
    public function get_tipo_de_archivo()
    {
        return $this->tipo_de_archivo;
    }
<<<<<<< HEAD
    public function set_clonable($clonable)
    {
        $this->clonable = $clonable;
    }
    public function get_clonable()
    {
        return $this->clonable;
    }
    public function set_opciones($opciones)
    {
        $this->opciones = $opciones;
    }
    public function get_opciones()
    {
        return $this->opciones;
    }
    public function set_titulo($valor)
    {
        $this->titulo = $valor;
    }
    public function get_titulo()
    {
        return $this->titulo;
    }
=======
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e

    public function crear_tipo_meta_box()
    {
        add_action('add_meta_boxes', array($this, 'crear_metadata'));
        add_action('save_post', array($this, 'guardar'));
    }

    public function crear_metadata()
    {
<<<<<<< HEAD
        add_meta_box($this->get_llave_meta(), $this->get_titulo_de_editor(), array($this, 'mostrar'), $this->get_post_type_de_origen());
=======
        add_meta_box($this->get_llave_meta(), $this->get_titulo(), array($this, 'mostrar'), $this->get_post_type_de_origen());
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
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
<<<<<<< HEAD
        $nuevo_titulo = '';
=======
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
        $nonce_name = $this->get_llave_meta();

        // Verificar si el nonce existe y es válido
        if (!isset($_POST[$nonce_name]) || !wp_verify_nonce($_POST[$nonce_name], $nonce_name)) {
            return;
        }

<<<<<<< HEAD
=======
        // Resto del código sin cambios...
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return;

        if (!current_user_can('edit_' . $this->get_post_type_de_origen(), $post_id))
            return;

<<<<<<< HEAD
        // Guardar los datos sin condiciones
        foreach ($this->contenido as $individual) {
            $meta_key = $this->get_llave_meta() . '_' . $individual->get_nombre_meta();

            // Si el campo es clonable
            if (method_exists($individual, 'get_clonable') && $individual->get_clonable()) {
=======
        // Save data unconditionally first
        foreach ($this->contenido as $individual) {
            $meta_key = $this->get_llave_meta() . '_' . $individual->get_nombre_meta();

            if ($individual instanceof MetaBoxTipoTextoClonable) {
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
                $valores = isset($_POST[$meta_key]) ? (array) $_POST[$meta_key] : array();
                $valores = array_filter(array_map('trim', $valores));

                delete_post_meta($post_id, $meta_key);
                foreach ($valores as $valor) {
                    if (!empty($valor)) {
                        add_post_meta($post_id, $meta_key, sanitize_text_field($valor));
                    }
                }
<<<<<<< HEAD
            }
            // Para campos de tipo dropdown
            elseif ($individual instanceof CampoDropDownTipoPost) {
                $valor = isset($_POST[$meta_key]) ? (int) $_POST[$meta_key] : 0;
                update_post_meta($post_id, $meta_key, $valor);
            } elseif ($individual instanceof CampoDropDownPredeterminado) {
                $valor = isset($_POST[$meta_key]) ? sanitize_text_field($_POST[$meta_key]) : '';
                update_post_meta($post_id, $meta_key, $valor);
            }
            // Para campos de texto simples u otros
            else {
=======
            } elseif ($individual instanceof MetaBoxTipoDropDownPostType) {
                $valor = isset($_POST[$meta_key]) ? (int) $_POST[$meta_key] : 0;
                update_post_meta($post_id, $meta_key, $valor);
            } else {
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
                $valor = isset($_POST[$meta_key]) ? trim($_POST[$meta_key]) : '';
                update_post_meta($post_id, $meta_key, sanitize_text_field($valor));
            }
        }

<<<<<<< HEAD
        // Actualizar el título y slug del post basado en el campo especificado
        if (!empty($this->get_titulo())) {
            if (!is_array($this->get_titulo())) {
                $meta_key_titulo = $this->get_llave_meta() . '_' . $this->get_titulo();
                $nuevo_titulo = get_post_meta($post_id, $meta_key_titulo, true);
            } else {
                foreach ($this->get_titulo() as $key => $cada_campo) {
                    $meta_key_titulo = $this->get_llave_meta() . '_' . $cada_campo;
                    $nuevo_titulo .= get_post_meta($post_id, $meta_key_titulo, true) . (($key < count($this->get_titulo()) - 1) ? ' - ' : '');
                }
            }
            if (!empty($nuevo_titulo)) {
                $post = get_post($post_id);
                if ($post->post_title !== $nuevo_titulo) {
                    remove_action('save_post', array($this, 'guardar'));
                    wp_update_post(array(
                        'ID' => $post_id,
                        'post_title' => $nuevo_titulo,
                        'post_name' => sanitize_title($nuevo_titulo)
                    ));
                    add_action('save_post', array($this, 'guardar'));
                }
            }
        }

        // Solo validar si se está publicando
=======
        // Only validate if publishing
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
        $is_publishing = isset($_POST['post_status']) && $_POST['post_status'] === 'publish';
        if (!$is_publishing)
            return;

        $errors = array();

<<<<<<< HEAD
        // Validar campos requeridos
        foreach ($this->contenido as $individual) {
            $meta_key = $this->get_llave_meta() . '_' . $individual->get_nombre_meta();

            if (method_exists($individual, 'get_clonable') && $individual->get_clonable()) {
=======
        // Validate required fields
        foreach ($this->contenido as $individual) {
            $meta_key = $this->get_llave_meta() . '_' . $individual->get_nombre_meta();

            if ($individual instanceof MetaBoxTipoTextoClonable) {
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
                $valores = get_post_meta($post_id, $meta_key, false);
                if (empty($valores)) {
                    $errors[] = sprintf(__('El campo "%s" debe tener al menos un valor'), $individual->get_etiqueta());
                }
<<<<<<< HEAD
            } elseif ($individual instanceof CampoDropDownTipoPost) {
=======
            } elseif ($individual instanceof MetaBoxTipoDropDownPostType) {
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
                $valor = get_post_meta($post_id, $meta_key, true);
                if (empty($valor) || $valor <= 0) {
                    $errors[] = sprintf(__('El campo "%s" es obligatorio'), $individual->get_etiqueta());
                }
<<<<<<< HEAD
            } elseif ($individual instanceof CampoDropDownPredeterminado) {
                $valor = get_post_meta($post_id, $meta_key, true);
                if (empty($valor)) {
                    $errors[] = sprintf(__('El campo "%s" es obligatorio'), $individual->get_etiqueta());
                }
=======
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
            } else {
                $valor = get_post_meta($post_id, $meta_key, true);
                if (empty($valor)) {
                    $errors[] = sprintf(__('El campo "%s" es obligatorio'), $individual->get_etiqueta());
                }
            }
        }

<<<<<<< HEAD
        // Manejar errores de validación
        if (!empty($errors)) {
            set_transient('inpsc_meta_errors_' . $post_id, $errors, 45);

            // Revertir a borrador
=======
        // Handle validation errors
        if (!empty($errors)) {
            set_transient('inpsc_meta_errors_' . $post_id, $errors, 45);

            // Revert to draft
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
            remove_action('save_post', array($this, 'guardar'));
            wp_update_post(array(
                'ID' => $post_id,
                'post_status' => 'draft'
            ));
            add_action('save_post', array($this, 'guardar'));
        } else {
            delete_transient('inpsc_meta_errors_' . $post_id);
        }
    }

<<<<<<< HEAD

=======
>>>>>>> 47a81b82f6c18c6434dce33803420df8b08c5c5e
    public function mostrar_errores()
    {
        global $post;

        if (!$post || $post->post_type !== $this->get_post_type_de_origen()) {
            return;
        }

        $transient_key = 'inpsc_meta_errors_' . $post->ID;
        $errors = get_transient($transient_key);

        if ($errors) {
            delete_transient($transient_key);
            ?>
            <div class="notice notice-error is-dismissible">
                <p><strong><?php _e('Error:', 'text-domain'); ?></strong></p>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo esc_html($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php
        }
    }
}