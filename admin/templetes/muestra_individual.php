<?php
/**
 * Single Materia Template
 */
get_header();

while (have_posts()):
    the_post(); ?>
    <article>
        <h1><?php the_title(); ?></h1>
        <div class="contenedorTabla">
            <table>
                <tbody>
                    <?php
                    generador(get_post_meta(get_the_ID()), get_the_ID(), 0);
                    ?>
                </tbody>
            </table>
        </div>
    </article>
<?php endwhile;

get_footer();

function generador($para_mostrar, $el_id)
{
    foreach ($para_mostrar as $key => $items) {
        $prefijo = 'INSPT_SISTEMA_DE_INSCRIPCIONES_' . get_post_type($el_id) . '_';
        if (strpos($key, $prefijo) === 0) {
            $campo = str_replace("ARCHIVO_", "", str_replace($prefijo, '', $key));
            $post_types = get_post_types([], 'names');
            ob_start(); // Inicia el buffer de salida
            ?>
            <tr>
                <th>
                    <?php echo esc_html(ucfirst(str_replace('_', ' ', $campo))); ?>
                </th>
                <?php
                // Genera el contenido del td en el buffer
                ob_start();
                if (in_array($campo, $post_types)) {
                    foreach ($items as $key => $item) {
                        $sub_meta = get_post_meta($item);
                        if (!empty($sub_meta)) {
                            if ($key != count($items) - 1) {
                                echo '<table class="borde_inferior_rojo"><tbody>';
                            } else {
                                echo '<table class=""><tbody>';
                            }
                            generador($sub_meta, $item);
                            echo '</tbody></table>';
                        }
                    }
                } elseif (count($items) > 1) {
                    echo '<ul>';
                    foreach ($items as $item) {
                        echo '<li>' . ($item) . '</li>';
                    }
                    echo '</ul>';
                } else {
                    foreach ($items as $item) {
                        $posible_json = json_decode($item);
                        if (is_numeric($item) && get_post($item) && get_post($item)->post_type === 'attachment') {
                            echo esc_html(the_attachment_link($item) . ' -> ' . size_format(wp_get_attachment_metadata($item)['filesize'], 2));
                        } elseif (is_array($posible_json)) {
                            foreach ($posible_json as $key => $items_json) {
                                if ($key != count($posible_json) - 1) {
                                    echo '<table class="borde_inferior_rojo"><tbody>';
                                } else {
                                    echo '<table class=""><tbody>';
                                }
                                foreach ($items_json as $key => $item_json) {
                                    echo '<tr><th>' . esc_html(ucfirst(str_replace('_', ' ', $key))) . '</th>';
                                    echo '<td>' . esc_html($item_json) . '</td>';
                                }
                                echo '</tr></tbody></table>';
                            }
                        } else {
                            if (str_contains($item, 'http')) {
                                echo '<a href="' . esc_html($item) . '">' . esc_html($item) . '</a>';
                            } else {
                                echo '<div>' . ($item) . '</div>';
                            }
                        }
                    }
                }
                $td_content = ob_get_clean();
                $has_table = strpos($td_content, '<table') !== false;
                ?>
                <td class="<?php echo $has_table ? 'no-padding' : ''; ?>">
                    <?php echo $td_content; ?>
                </td>
            </tr>
            <?php
            ob_end_flush();
        }
    }
}