<?php
require_once dirname(__FILE__) . '/../mailing/mailing.php';

class CamposPersonalizados
{
    private $campos;
    private $campos_de_reemplazo_nombre_de_usuario;
    private $generated_username = '';

    public function __construct($campos = array(), $campos_de_reemplazo_nombre_de_usuario = array())
    {
        $this->campos = $campos;
        $this->campos_de_reemplazo_nombre_de_usuario = $campos_de_reemplazo_nombre_de_usuario;

        // Agregar campos al registrarse
        add_action('register_form', array($this, 'agregar_campos_registro'));
        add_filter('registration_errors', array($this, 'validar_campos_registro'), 10, 3);
        add_filter('pre_user_login', array($this, 'generar_nombre_usuario'));
        add_action('user_register', array($this, 'guardar_campos_personalizados'));

        // Agregar campos al perfil de usuario
        add_action('show_user_profile', array($this, 'mostrar_campos_perfil'));
        add_action('edit_user_profile', array($this, 'mostrar_campos_perfil'));
        add_filter('user_profile_update_errors', array($this, 'validar_campos_perfil'), 10, 3);
        add_action('personal_options_update', array($this, 'guardar_campos_perfil'));
        add_action('edit_user_profile_update', array($this, 'guardar_campos_perfil'));
    }

    public function agregar_campos_registro()
    {
        echo '<style>#registerform > p:first-child { display: none; }</style>';

        foreach ($this->campos as $campo) {
            echo sprintf(
                '<p>
                    <label for="%s">%s</label>
                    <input type="text" name="%s" id="%s" class="input" value="%s" required />
                </p>',
                esc_attr($campo->get_id_campo()),
                esc_html($campo->get_texto_para_mostrar()),
                esc_attr($campo->get_id_campo()),
                esc_attr($campo->get_id_campo()),
                isset($_POST[$campo->get_id_campo()]) ? esc_attr($_POST[$campo->get_id_campo()]) : ''
            );
        }
    }

    public function validar_campos_registro($errors, $sanitized_user_login, $user_email)
    {
        $username_parts = array();

        if (isset($errors->errors['empty_username'])) {
            unset($errors->errors['empty_username']);
        }

        foreach ($this->campos as $campo) {
            $id = $campo->get_id_campo();
            $valor = isset($_POST[$id]) ? trim($_POST[$id]) : '';
            $tipo = $campo->get_tipo_de_input();

            // Validación de campo requerido
            if (empty($valor)) {
                $errors->add($id . '_error', sprintf(__('%s es requerido.'), $campo->get_texto_para_mostrar()));
                continue;
            }

            // Validación de formato
            $error_validacion = $this->validar_valor($valor, $tipo, $campo->get_texto_para_mostrar());
            if ($error_validacion) {
                $errors->add($id . '_error', $error_validacion);
            }

            // Validación de unicidad
            if (!$campo->get_puede_repetirse()) {
                $valor_sanitizado = $this->sanitizar_valor($valor, $tipo, $campo->get_primera_debe_ser_mayuscula());
                $users = get_users([
                    'meta_key' => $id,
                    'meta_value' => $valor_sanitizado,
                    'number' => 1
                ]);

                if (!empty($users)) {
                    $errors->add($id . '_error', sprintf(__('%s ya está registrado.'), $campo->get_texto_para_mostrar()));
                }
            }

            // Preparar username
            if (in_array($campo->get_id_campo(), $this->campos_de_reemplazo_nombre_de_usuario)) {
                $username_parts[] = $this->sanitizar_valor($valor, $tipo, $campo->get_primera_debe_ser_mayuscula());
            }
        }

        // Generar username único
        if (!empty($username_parts)) {
            $generated_username = implode('.', $username_parts);
            $generated_username = sanitize_user($generated_username);

            $original_username = $generated_username;
            $counter = 1;
            while (username_exists($generated_username)) {
                $generated_username = $original_username . '.' . $counter;
                $counter++;
            }
            $this->generated_username = $generated_username;
        }

        return $errors;
    }

    public function generar_nombre_usuario($user_login)
    {
        return !empty($this->generated_username) ? $this->generated_username : $user_login;
    }

    public function guardar_campos_personalizados($user_id)
    {
        foreach ($this->campos as $campo) {
            $id = $campo->get_id_campo();
            if (isset($_POST[$id])) {
                $valor_sanitizado = $this->sanitizar_valor(
                    $_POST[$id],
                    $campo->get_tipo_de_input(),
                    $campo->get_primera_debe_ser_mayuscula()
                );
                update_user_meta($user_id, $id, $valor_sanitizado);
            }
        }
    }

    private function sanitizar_valor($valor, $tipo, $primera_debe_ser_mayuscula)
    {
        $valor = trim($valor);
        switch ($tipo) {
            case 'int':
                return filter_var($valor, FILTER_VALIDATE_INT);
            case 'float':
                $valor = str_replace(',', '.', $valor);
                return filter_var($valor, FILTER_VALIDATE_FLOAT);
            default: // string
                return ($primera_debe_ser_mayuscula) ? ucfirst(sanitize_text_field($valor)) : sanitize_text_field($valor);
        }
    }

    private function validar_valor($valor, $tipo, $etiqueta)
    {
        $valor = trim($valor);
        if (empty($valor))
            return null;

        switch ($tipo) {
            case 'int':
                if (preg_match('/\s/', $valor)) {
                    return sprintf(__('El campo "%s" no puede contener espacios'), $etiqueta);
                }
                if (!ctype_digit(str_replace('-', '', $valor))) {
                    return sprintf(__('El campo "%s" debe ser un número entero válido'), $etiqueta);
                }
                break;

            case 'float':
                if (preg_match('/\s/', $valor)) {
                    return sprintf(__('El campo "%s" no puede contener espacios'), $etiqueta);
                }
                if (substr_count($valor, ',') > 1) {
                    return sprintf(__('El campo "%s" debe tener máximo una coma decimal'), $etiqueta);
                }
                $float_val = str_replace(',', '.', $valor);
                if (!is_numeric($float_val)) {
                    return sprintf(__('El campo "%s" debe ser un número decimal válido'), $etiqueta);
                }
                break;

            case 'string':
            default:
                // No se aplican restricciones adicionales
                break;
        }

        return null;
    }

    public function mostrar_campos_perfil($user)
    {
        $default_fields = array(
            'first_name',
            'last_name',
            'nickname',
            'display_name',
            'email',
            'url',
            'description',
            'user_login'
        );

        $custom_fields = array_filter($this->campos, function ($campo) use ($default_fields) {
            return !in_array($campo->get_id_campo(), $default_fields);
        });

        if (!empty($custom_fields)) {
            echo '<h3>Campos Personalizados</h3>';
            echo '<table class="form-table">';

            foreach ($custom_fields as $campo) {
                $id = $campo->get_id_campo();
                $valor = get_user_meta($user->ID, $id, true);

                echo '<tr>';
                echo '<th><label for="' . esc_attr($id) . '">'
                    . esc_html($campo->get_texto_para_mostrar()) . '</label></th>';
                echo '<td><input type="text" name="' . esc_attr($id) . '" id="' . esc_attr($id) . '" 
                             value="' . esc_attr($valor) . '" class="regular-text" /></td>';
                echo '</tr>';
            }

            echo '</table>';
        }
    }

    /**
     * Valida campos personalizados en la edición de perfil
     */
    public function validar_campos_perfil($errors, $update, $user)
    {
        $default_fields = array(
            'first_name',
            'last_name',
            'nickname',
            'display_name',
            'email',
            'url',
            'description',
            'user_login'
        );

        foreach ($this->campos as $campo) {
            $id = $campo->get_id_campo();

            if (in_array($id, $default_fields)) {
                continue;
            }

            $valor = isset($_POST[$id]) ? trim($_POST[$id]) : '';
            $tipo = $campo->get_tipo_de_input();

            // Validación requerida
            if (empty($valor)) {
                $errors->add(
                    $id . '_error',
                    sprintf(__('El campo %s es requerido.'), $campo->get_texto_para_mostrar())
                );
            }

            // Validación de formato
            $error_validacion = $this->validar_valor($valor, $tipo, $campo->get_texto_para_mostrar());
            if ($error_validacion) {
                $errors->add($id . '_error', $error_validacion);
            }

            // Validación de unicidad
            if (!$campo->get_puede_repetirse()) {
                $valor_sanitizado = $this->sanitizar_valor(
                    $valor,
                    $tipo,
                    $campo->get_primera_debe_ser_mayuscula()
                );

                $users = get_users([
                    'meta_key' => $id,
                    'meta_value' => $valor_sanitizado,
                    'exclude' => array($user->ID),
                    'number' => 1
                ]);

                if (!empty($users)) {
                    $errors->add(
                        $id . '_error',
                        sprintf(__('%s ya está registrado.'), $campo->get_texto_para_mostrar())
                    );
                }
            }
        }

        return $errors;
    }

    /**
     * Guarda campos personalizados en la edición de perfil
     */
    public function guardar_campos_perfil($user_id)
    {
        if (!current_user_can('edit_user', $user_id))
            return;

        $default_fields = array(
            'first_name',
            'last_name',
            'nickname',
            'display_name',
            'email',
            'url',
            'description',
            'user_login'
        );

        foreach ($this->campos as $campo) {
            $id = $campo->get_id_campo();

            if (!in_array($id, $default_fields) && isset($_POST[$id])) {
                $valor_sanitizado = $this->sanitizar_valor(
                    $_POST[$id],
                    $campo->get_tipo_de_input(),
                    $campo->get_primera_debe_ser_mayuscula()
                );

                update_user_meta($user_id, $id, $valor_sanitizado);
            }
        }
    }
}