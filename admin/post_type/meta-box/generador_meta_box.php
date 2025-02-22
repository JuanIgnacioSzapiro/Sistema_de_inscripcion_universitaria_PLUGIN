<?php // generador_meta_box.php

class TipoMetaBox
{
    protected $prefijo = 'INSPT_SISTEMA_DE_INSCRIPCIONES';
    protected $post_type_de_origen; //post_type al que pertenece
    protected $titulo_de_editor;
    protected $contenido;
    protected $nombre_meta;
    protected $etiqueta;
    protected $texto_de_ejemplificacion;
    protected $descripcion;
    protected $post_type_buscado;
    protected $tipo_de_archivo;
    protected $clonable;
    protected $opciones;
    protected $titulo;

    public function __construct($titulo_de_editor, $contenido, $titulo)
    {
        $this->set_titulo_de_editor($titulo_de_editor);
        $this->set_contenido($contenido);
        $this->set_titulo($titulo);

        add_action('admin_notices', array($this, 'mostrar_errores'));
    }

    public function set_post_type_de_origen($post_type_de_origen)
    {
        $this->post_type_de_origen = $post_type_de_origen;
    }

    public function set_titulo_de_editor($titulo_de_editor)
    {
        $this->titulo_de_editor = $titulo_de_editor;
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
        return $this->prefijo . '_' . $this->get_post_type_de_origen();
    }

    public function get_post_type_de_origen()
    {
        return $this->post_type_de_origen;
    }

    public function get_titulo_de_editor()
    {
        return $this->titulo_de_editor;
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

    public function crear_tipo_meta_box()
    {
        add_action('add_meta_boxes', array($this, 'crear_metadata'));
        add_action('save_post', array($this, 'guardar'));
    }

    public function crear_metadata()
    {
        add_meta_box($this->get_llave_meta(), $this->get_titulo_de_editor(), array($this, 'mostrar'), $this->get_post_type_de_origen());
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
        $nuevo_titulo = '';
        $nonce_name = $this->get_llave_meta();

        if (!isset($_POST[$nonce_name]))
            return;
        if (!wp_verify_nonce($_POST[$nonce_name], $nonce_name))
            return;
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return;
        if (!current_user_can('edit_' . $this->get_post_type_de_origen(), $post_id))
            return;

        foreach ($this->contenido as $individual) {
            $meta_key = $this->get_llave_meta() . '_' . $individual->get_nombre_meta();

            // 1. Manejo de campos clonables (incluyendo dropdowns)
            if ($individual->get_clonable()) {
                $valores = isset($_POST[$meta_key]) ? (array) $_POST[$meta_key] : [];

                // Sanitización específica por tipo de campo
                $sanitized_values = [];
                foreach ($valores as $valor) {
                    if ($individual instanceof CampoDropDownTipoPost) {
                        $clean_value = intval($valor);
                        if ($clean_value > 0)
                            $sanitized_values[] = $clean_value;
                    } else {
                        $clean_value = sanitize_text_field(trim($valor));
                        if (!empty($clean_value))
                            $sanitized_values[] = $clean_value;
                    }
                }

                delete_post_meta($post_id, $meta_key);
                foreach ($sanitized_values as $value) {
                    add_post_meta($post_id, $meta_key, $value);
                }
            }
            // 2. Campos dropdown NO clonables
            elseif ($individual instanceof CampoDropDownTipoPost) {
                $valor = isset($_POST[$meta_key]) ? intval($_POST[$meta_key]) : 0;
                update_post_meta($post_id, $meta_key, $valor);
            }
            // 3. Otros tipos de campos
            else {
                $valor = isset($_POST[$meta_key]) ? sanitize_text_field(trim($_POST[$meta_key])) : '';
                update_post_meta($post_id, $meta_key, $valor);
            }
        }

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

        // Validación durante la publicación
        $is_publishing = isset($_POST['post_status']) && $_POST['post_status'] === 'publish';
        if (!$is_publishing)
            return;

        $errors = [];
        foreach ($this->contenido as $individual) {
            $meta_key = $this->get_llave_meta() . '_' . $individual->get_nombre_meta();
            $valores = get_post_meta($post_id, $meta_key, !$individual->get_clonable());

            // Validación para campos requeridos
            if (empty($valores) || (is_array($valores) && count($valores) === 0)) {
                $errors[] = sprintf(__('El campo "%s" es obligatorio'), $individual->get_etiqueta());
                continue;
            }

            // Validación específica para dropdowns clonables
            if ($individual->get_clonable() && $individual instanceof CampoDropDownTipoPost) {
                foreach ((array) $valores as $valor) {
                    if (!get_post($valor)) {
                        $errors[] = sprintf(__('Valor inválido en "%s'), $individual->get_etiqueta());
                        break;
                    }
                }
            }
        }

        if (!empty($errors)) {
            set_transient('inpsc_meta_errors_' . $post_id, $errors, 45);
            remove_action('save_post', [$this, 'guardar']);
            wp_update_post(['ID' => $post_id, 'post_status' => 'draft']);
            add_action('save_post', [$this, 'guardar']);
        } else {
            delete_transient('inpsc_meta_errors_' . $post_id);
        }
    }

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