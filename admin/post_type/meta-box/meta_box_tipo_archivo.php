<?php //meta_box_tipo_archivo.php
class CampoArchivo extends TipoMetaBox
{
    public function __construct(
        $nombre_meta,
        $etiqueta,
        $tipo_de_archivo,
        $descripcion,
        $clonable = false
    ) {
        $this->set_nombre_meta($nombre_meta);
        $this->set_etiqueta($etiqueta);
        $this->set_tipo_de_archivo($tipo_de_archivo);
        $this->set_descripcion($descripcion);
        $this->set_clonable($clonable);
    }

    public function generar_fragmento_html($post, $llave)
    {
        $meta_key = $llave . '_' . 'ARCHIVO' . '_' . $this->nombre_meta;
        $current_file_id = get_post_meta($post->ID, $meta_key, true);

        wp_enqueue_media();
        ?>
        <label for="<?php echo esc_attr($meta_key); ?>"><?php echo esc_html($this->etiqueta); ?></label>
        <input type="hidden" id="<?php echo esc_attr($meta_key); ?>" name="<?php echo esc_attr($meta_key); ?>"
            value="<?php echo esc_attr($current_file_id); ?>" />
        <br>
        <button type="button" class="button upload-file-btn" data-target="<?php echo esc_attr($meta_key); ?>">
            <?php esc_html_e('Subir archivo', 'text-domain'); ?>
        </button>

        <?php if ($current_file_id):
            $attachment = get_post($current_file_id);
            if ($attachment && 'attachment' === $attachment->post_type):
                $metadata = wp_get_attachment_metadata($current_file_id);
                $file_size = 0;

                if ($metadata && isset($metadata['filesize'])) {
                    $file_size = $metadata['filesize'];
                } else {
                    $file_path = get_attached_file($current_file_id);
                    if ($file_path && file_exists($file_path)) {
                        $file_size = filesize($file_path);
                    }
                }
                $file_size_formatted = $file_size ? size_format($file_size, 2) : __('No disponible', 'text-domain');
                ?>
                <p class="file-info">
                    <?php echo esc_html(the_attachment_link($current_file_id) . ' -> ' . $file_size_formatted); ?>
                </p>
            <?php endif; ?>
        <?php endif; ?>

        <p class="description"><?php echo esc_html($this->descripcion); ?></p>
        <script>
            jQuery(document).ready(function ($) {
                if (typeof window.initArchivo !== 'function') {
                    window.initArchivo = function () {
                        $('.upload-file-btn').click(function (e) {
                            e.preventDefault();
                            var target = $(this).data('target');
                            var file_frame = wp.media.frames.file_frame = wp.media({
                                title: '<?php esc_html_e('Seleccionar archivo', 'text-domain'); ?>',
                                button: { text: '<?php esc_html_e('Usar este archivo', 'text-domain'); ?>' },
                                multiple: false,
                                library: { type: '<?php echo esc_js($this->tipo_de_archivo); ?>' }
                            });
                            file_frame.on('select', function () {
                                var attachment = file_frame.state().get('selection').first().toJSON();
                                $('#' + target).val(attachment.id);
                            });
                            file_frame.open();
                        });
                    }
                }
                // Initialize when DOM is ready
                $(document).ready(function () {
                    if (!window.archivoInit) {
                        window.initArchivo();
                        window.archivoInit = true;
                    }
                });
            });
        </script>
        <?php
    }
}