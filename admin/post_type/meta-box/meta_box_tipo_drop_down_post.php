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

        if (!$this->get_clonable()) {
            // Lógica NO clonable (igual a la versión anterior)
            $selected_value = get_post_meta($post->ID, $meta_key, true);
            $posts = $this->obtener_posts();
            ?>
            <div class="campo-dropdown-container">
                <?php $this->generar_buscador_y_select($meta_key, $posts, $selected_value); ?>
            </div>
            <?php
        } else {
            // Lógica CLONABLE (nueva)
            $values = get_post_meta($post->ID, $meta_key);
            ?>
            <div class="clonable-container">
                <label><?php echo esc_html($this->get_etiqueta()); ?></label>
                <div class="clonable-fields">
                    <?php
                    if (empty($values)) $values = [''];
                    foreach ($values as $value) {
                        $this->generar_campo_clonable($meta_key, $value);
                    }
                    ?>
                </div>
                <button type="button" class="button add-field">Agregar más</button>
                <p class="description"><?php echo esc_html($this->get_descripcion()); ?></p>
            </div>
            <?php
        }

        $this->agregar_scripts();
    }

    private function obtener_posts() {
        return get_posts([
            'post_type' => $this->get_post_type_buscado(),
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'title',
            'order' => 'ASC'
        ]);
    }

    private function generar_buscador_y_select($meta_key, $posts, $selected_value, $is_clonable = false) {
        $unique_id = uniqid();
        ?>
        <input 
            id="buscador_<?php echo esc_attr($unique_id); ?>" 
            type="text" 
            placeholder="Buscador" 
            class="buscador-dropdown"
        >
        <select 
            name="<?php echo $is_clonable ? esc_attr($meta_key) . '[]' : esc_attr($meta_key); ?>" 
            id="<?php echo esc_attr($meta_key . '_' . $unique_id); ?>"
        >
            <option value="">Seleccionar...</option>
            <?php foreach ($posts as $post_option): ?>
                <option 
                    value="<?php echo esc_attr($post_option->ID); ?>" 
                    <?php selected($selected_value, $post_option->ID); ?>
                >
                    <?php echo esc_html($post_option->post_title); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>
        <?php
    }

    private function generar_campo_clonable($meta_key, $selected_value) {
        $posts = $this->obtener_posts();
        ?>
        <div class="clonable-field">
            <div class="campo-dropdown-container">
                <?php $this->generar_buscador_y_select($meta_key, $posts, $selected_value, true); ?>
                <button type="button" class="button remove-field">Eliminar</button>
            </div>
        </div>
        <?php
    }

    private function agregar_scripts() {
        if (!self::$js_added) {
            ?>
            <script>
                (function($) {
                    // Función única para manejar clonado
                    if (!window.hasOwnProperty('clonableDropdownHandler')) {
                        window.clonableDropdownHandler = {
                            init: function() {
                                // Eventos para clonado
                                $(document)
                                    .on('click', '.clonable-container .add-field', function(e) {
                                        const container = $(this).closest('.clonable-container');
                                        const newField = container.find('.clonable-field:last').clone();
                                        newField.find('select, input').val('');
                                        container.find('.clonable-fields').append(newField);
                                    })
                                    .on('click', '.clonable-container .remove-field', function(e) {
                                        if ($(this).closest('.clonable-fields').find('.clonable-field').length > 1) {
                                            $(this).closest('.clonable-field').remove();
                                        }
                                    });

                                // Evento único para búsqueda con delegación
                                $(document).on('input', '.buscador-dropdown', function(e) {
                                    const searchText = $(this).val().toLowerCase();
                                    const container = $(this).closest('.campo-dropdown-container');
                                    
                                    container.find('select option').each(function() {
                                        const $option = $(this);
                                        $option.toggle(
                                            $option.text().toLowerCase().includes(searchText) || 
                                            $option.val() === ''
                                        );
                                    });
                                });
                            }
                        };
                        
                        // Inicialización automática al cargar
                        $(document).ready(function() {
                            window.clonableDropdownHandler.init();
                        });
                    }
                })(jQuery);
            </script>
            <?php
            self::$js_added = true;
        }
    }
}