<?php
/**
 * Single Materia Template
 */
get_header();

while (have_posts()):
    the_post(); ?>
    <article>
        <h1><?php the_title(); ?></h1>

        <table>
            <tbody>
                <?php
                generador(get_post_meta(get_the_ID()), get_the_ID(), 0);
                ?>
            </tbody>
        </table>

    </article>
<?php endwhile;

get_footer();

function generador($para_mostrar, $el_id, $margen)
{
    foreach ($para_mostrar as $key => $items) {
        $prefijo = 'INSPT_SISTEMA_DE_INSCRIPCIONES_' . get_post_type($el_id) . '_';

        if (strpos($key, $prefijo) === 0) {
            $campo = str_replace("ARCHIVO", "", str_replace($prefijo, '', $key));
            $post_types = get_post_types([], 'names');

            ?>
            <tr>
                <th style="padding-left: <?php echo $margen; ?>px;">
                    <?php echo esc_html(ucfirst(str_replace('_', ' ', $campo))); ?>
                </th>
                <td>
                    <?php
                    if (in_array($campo, $post_types)) {
                        foreach ($items as $item) {
                            $sub_meta = get_post_meta($item);
                            if (!empty($sub_meta)) {
                                echo '<table><tbody>';
                                generador($sub_meta, $item, $margen + 20);
                                echo '</tbody></table>';
                            }
                        }
                    } else {
                        foreach ($items as $item) {
                            $posible_json = json_decode($item);
                            if (is_numeric($item) && get_post($item) && get_post($item)->post_type === 'attachment') {
                                echo esc_html(the_attachment_link($item) . ' -> ' . size_format(wp_get_attachment_metadata($item)['filesize'], 2));

                            } elseif (is_array($posible_json)) {
                                foreach ($posible_json as $items_json) {
                                    foreach ($items_json as $key => $item_json) {
                                        echo '<table><tbody>';
                                        echo '<th>' . esc_html(ucfirst(str_replace('_', ' ', $key))) . '</th>';
                                        echo '<td>' . esc_html($item_json) . '</td>';
                                        echo '</tbody></table>';
                                    }
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
                    ?>
                </td>
            </tr>
            <?php
        }
    }
}