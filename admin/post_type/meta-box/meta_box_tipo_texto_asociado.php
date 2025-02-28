<?php // meta_box_tipo_texto.php
require_once dirname(__FILE__) . '/generador_meta_box.php';

class CampoTextoAsociado extends TipoMetaBox
{
    public function __construct(
        $nombre_meta_1,
        $etiqueta_1,
        $texto_de_ejemplificacion_1,
        $descripcion_1,
        $nombre_meta_2,
        $etiqueta_2,
        $texto_de_ejemplificacion_2,
        $descripcion_2,
        $tipo_de_input_1 = 'string',
        $tipo_de_input_2 = 'string',
        $clonable = false
    ) {
        $this->set_nombre_meta($nombre_meta_1);
        $this->set_etiqueta($etiqueta_1);
        $this->set_texto_de_ejemplificacion($texto_de_ejemplificacion_1);
        $this->set_descripcion($descripcion_1);
        $this->set_tipo_de_input($tipo_de_input_1);
        $this->set_nombre_meta_asociado2($nombre_meta_2);
        $this->set_etiqueta_asociado2($etiqueta_2);
        $this->set_texto_de_ejemplificacion_asociado2($texto_de_ejemplificacion_2);
        $this->set_descripcion_asociado2($descripcion_2);
        $this->set_tipo_de_input_asociado2($tipo_de_input_2);
        $this->set_clonable($clonable);
    }


    public function generar_fragmento_html($post, $llave)
    {
        if (!$this->get_clonable()) {
            // ... (código para campos no clonables igual)
        } else {
            // Campos clonables con nueva estructura de clave
            $group_meta_key = $llave . '_' . $this->get_nombre_meta() . '_' . $this->get_nombre_meta_asociado2();
            $group_values = get_post_meta($post->ID, $group_meta_key, true);

            if (!is_array($group_values)) {
                $group_values = array();
            }

            if (empty($group_values)) {
                $group_values = array(
                    array(
                        $this->get_nombre_meta() => '',
                        $this->get_nombre_meta_asociado2() => ''
                    )
                );
            }
            ?>
            <div class="clonable-container">
                <div class="clonable-fields">
                    <?php foreach ($group_values as $i => $pair): ?>
                        <div class="clonable-field" style="margin-bottom: 15px; border-bottom: 1px solid #ddd; padding-bottom: 15px;">
                            <label>
                                <?php echo esc_html($this->get_etiqueta()); ?>
                            </label>
                            <input type="text"
                                name="<?php echo esc_attr($group_meta_key); ?>[<?php echo $i; ?>][<?php echo esc_attr($this->get_nombre_meta()); ?>]"
                                value="<?php echo esc_attr($pair[$this->get_nombre_meta()]); ?>"
                                placeholder="<?php echo esc_attr($this->get_texto_de_ejemplificacion()); ?>"
                                style="width: 100%; margin-bottom: 5px;" />
                            <p class="description">
                                <?php echo esc_html($this->get_descripcion()); ?>
                            </p>

                            <label>
                                <?php echo esc_html($this->get_etiqueta_asociado2()); ?>
                            </label>
                            <input type="text"
                                name="<?php echo esc_attr($group_meta_key); ?>[<?php echo $i; ?>][<?php echo esc_attr($this->get_nombre_meta_asociado2()); ?>]"
                                value="<?php echo esc_attr($pair[$this->get_nombre_meta_asociado2()]); ?>"
                                placeholder="<?php echo esc_attr($this->get_texto_de_ejemplificacion_asociado2()); ?>"
                                style="width: 100%; margin-bottom: 5px;" />
                            <p class="description">
                                <?php echo esc_html($this->get_descripcion_asociado2()); ?>
                            </p>
                            <button type="button" class="button remove-field">Eliminar</button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="button add-field" style="margin-top: 10px;">Agregar más</button>
            </div>
            <script>
                (function ($) {
                    $(document).ready(function () {
                        $('.clonable-container').each(function () {
                            const container = $(this);
                            const groupMetaKey = '<?php echo esc_js($group_meta_key); ?>';

                            container.on('click', '.add-field', function (e) {
                                e.preventDefault();
                                const lastField = container.find('.clonable-field:last');
                                const newField = lastField.clone();
                                const index = container.find('.clonable-field').length;

                                newField.find('input').each(function () {
                                    const name = $(this).attr('name');
                                    const newName = name.replace(/\[\d+\]\[/, '[' + index + '][');
                                    $(this).attr('name', newName).val('');
                                });

                                container.find('.clonable-fields').append(newField);
                            });

                            container.on('click', '.remove-field', function (e) {
                                e.preventDefault();
                                if (container.find('.clonable-field').length > 1) {
                                    $(this).closest('.clonable-field').remove();
                                    container.find('.clonable-field').each(function (i) {
                                        $(this).find('input').each(function () {
                                            const name = $(this).attr('name');
                                            const newName = name.replace(/\[\d+\]\[/, '[' + i + '][');
                                            $(this).attr('name', newName);
                                        });
                                    });
                                }
                            });
                        });
                    });
                })(jQuery);
            </script>
            <?php
        }
    }
}