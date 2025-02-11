<?php
require_once dirname(__FILE__) . '/meta_box_tipo_texto.php';

class MetaBoxTipoTextoClonable extends MetaBoxTipoTexto {
    public function generar_fragmento_html($post, $llave) {
        $meta_llave = $llave . '_' . $this->get_nombre_meta();
        $values = get_post_meta($post->ID, $meta_llave);
        ?>
        <div class="clonable-container">
            <label for="<?php echo esc_attr($meta_llave); ?>">
                <?php echo esc_html($this->get_etiqueta()); ?>
            </label>
            <div class="clonable-fields">
                <?php foreach ($values as $value): ?>
                <div class="clonable-field">
                    <input type="text" name="<?php echo esc_attr($meta_llave); ?>[]"
                        value="<?php echo esc_attr($value); ?>"
                        placeholder="<?php echo esc_attr($this->get_texto_de_ejemplificacion()); ?>"
                        style="width: 100%; margin-bottom: 5px;" />
                    <button type="button" class="button remove-field">Eliminar</button>
                </div>
                <?php endforeach; ?>
                <?php if (empty($values)): ?>
                <div class="clonable-field">
                    <input type="text" name="<?php echo esc_attr($meta_llave); ?>[]"
                        placeholder="<?php echo esc_attr($this->get_texto_de_ejemplificacion()); ?>"
                        style="width: 100%; margin-bottom: 5px;" />
                    <button type="button" class="button remove-field">Eliminar</button>
                </div>
                <?php endif; ?>
            </div>
            <button type="button" class="button add-field">Agregar más</button>
            <p class="description">
                <?php echo esc_html($this->get_descripcion()); ?>
            </p>
        </div>
        <script>
            jQuery(document).ready(function($) {
                $('.clonable-container').each(function() {
                    var container = $(this);
                    container.on('click', '.add-field', function() {
                        var newField = container.find('.clonable-field:last').clone();
                        newField.find('input').val('');
                        container.find('.clonable-fields').append(newField);
                    });
                    container.on('click', '.remove-field', function() {
                        if (container.find('.clonable-field').length > 1) {
                            $(this).closest('.clonable-field').remove();
                        }
                    });
                });
            });
        </script>
        <?php
    }
}