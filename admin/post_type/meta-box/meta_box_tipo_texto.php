<?php // meta_box_tipo_texto.php
require_once dirname(__FILE__) . '/generador_meta_box.php';

class CampoTexto extends TipoMetaBox
{
    public function __construct(
        $nombre_meta,
        $etiqueta,
        $texto_de_ejemplificacion,
        $descripcion,
        $clonable = false,
        $tipo_de_input = 'string',
        $es_campo_opcional = false,
    ) {
        $this->set_nombre_meta($nombre_meta);
        $this->set_etiqueta($etiqueta);
        $this->set_texto_de_ejemplificacion($texto_de_ejemplificacion);
        $this->set_descripcion($descripcion);
        $this->set_clonable($clonable);
        $this->set_tipo_de_input($tipo_de_input);
        $this->set_es_campo_opcional($es_campo_opcional);
    }
    public function generar_fragmento_html($post, $llave)
    {
        if (!$this->get_clonable()) {
            $meta_key = $llave . '_' . $this->get_nombre_meta();
            $custom_field_value = get_post_meta($post->ID, $meta_key, true);
            if ($this->get_es_campo_opcional()) {
                ?>
                <label for="<?php echo esc_attr($meta_key); ?>">
                    <?php echo esc_html($this->get_etiqueta()); ?>
                </label>
                <?php
            } else {
                ?>
                <label class="no-opcional" for="<?php echo esc_attr($meta_key); ?>">
                    <?php echo esc_html($this->get_etiqueta()); ?> *
                </label>
                <div class="no-opcional-comentario">Este campo es OBLIGATORIO</div>
                <?php
            }
            ?>
            <input type="text" id="<?php echo esc_attr($meta_key); ?>" name="<?php echo esc_attr($meta_key); ?>"
                value="<?php echo esc_attr($custom_field_value); ?>"
                placeholder="<?php echo esc_attr($this->get_texto_de_ejemplificacion()); ?>" style="width: 100%;" />
            <p class="description">
                <?php echo esc_html($this->get_descripcion()); ?>
            </p>
            <?php
        } else {
            $meta_key = $llave . '_' . $this->get_nombre_meta();
            $values = get_post_meta($post->ID, $meta_key);
            ?>
            <div class="clonable-container">
                <?php
                if ($this->get_es_campo_opcional()) {
                    ?>
                    <label for="<?php echo esc_attr($meta_key); ?>">
                        <?php echo esc_html($this->get_etiqueta()); ?>
                    </label>
                    <?php
                } else {
                    ?>
                    <label class="no-opcional" for="<?php echo esc_attr($meta_key); ?>">
                        <?php echo esc_html($this->get_etiqueta()); ?> *
                    </label>
                    <div class="no-opcional-comentario">Este campo es OBLIGATORIO</div>
                    <?php
                }
                ?>
                <div class="clonable-fields">
                    <?php
                    // Always render at least ONE field (even if empty)
                    if (empty($values)) {
                        $values = [''];
                    }
                    foreach ($values as $value) { ?>
                        <div class="clonable-field">
                            <input type="text" name="<?php echo esc_attr($meta_key); ?>[]" value="<?php echo esc_attr($value); ?>"
                                placeholder="<?php echo esc_attr($this->get_texto_de_ejemplificacion()); ?>"
                                style="width: 100%; margin-bottom: 5px;" />
                            <button type="button" class="button remove-field">Eliminar</button>
                        </div>
                    <?php } ?>
                </div>
                <button type="button" class="button add-field">Agregar más</button>
                <p class="description">
                    <?php echo esc_html($this->get_descripcion()); ?>
                </p>
            </div>
            <script>
                (function ($) {
                    // Only define once in global scope
                    if (typeof window.initClonableFields !== 'function') {
                        window.initClonableFields = function () {
                            $(document)
                                .off('click', '.clonable-container .add-field') // Prevent duplicate bindings
                                .on('click', '.clonable-container .add-field', function (e) {
                                    e.preventDefault();
                                    const container = $(this).closest('.clonable-container');
                                    const newField = container.find('.clonable-field:last').clone();
                                    newField.find('input').val('');
                                    container.find('.clonable-fields').append(newField);
                                })
                                .off('click', '.clonable-container .remove-field')
                                .on('click', '.clonable-container .remove-field', function (e) {
                                    e.preventDefault();
                                    const container = $(this).closest('.clonable-container');
                                    if (container.find('.clonable-field').length > 1) {
                                        $(this).closest('.clonable-field').remove();
                                    }
                                });
                        };
                    }

                    // Initialize when DOM is ready
                    $(document).ready(function () {
                        if (!window.clonableFieldsInitialized) {
                            window.initClonableFields();
                            window.clonableFieldsInitialized = true;
                        }
                    });
                })(jQuery);
            </script>
            <?php
        }
    }
}