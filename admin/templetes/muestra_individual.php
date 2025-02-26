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

function generador($para_mostrar, $el_id, $margen, $profundidad = 0) {
    // Prevención de recursión infinita
    if ($profundidad > 3) {
        echo '<!-- Profundidad máxima alcanzada -->';
        return;
    }

    foreach ($para_mostrar as $key => $items) {
        $prefijo = 'INSPT_SISTEMA_DE_INSCRIPCIONES_' . get_post_type($el_id) . '_';
        
        if (strpos($key, $prefijo) === 0) {
            $campo = str_replace($prefijo, '', $key);
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
                                generador($sub_meta, $item, $margen + 20, $profundidad + 1);
                                echo '</tbody></table>';
                            }
                        }
                    } else {
                        $valores_seguros = array_map('esc_html', $items);
                        echo implode('<br>', $valores_seguros);
                    }
                    ?>
                </td>
            </tr>
            <?php
        }
    }
}