<?php
/**
 * Single Materia Template
 */
get_header();

while (have_posts()):
    the_post();
    if (in_array('read_' . get_post_type(), wp_get_current_user()->allcaps)) {
        ?>
        <article>
            <h1><?php the_title(); ?></h1>
            <div class="contenedorTabla">
                <table>
                    <tbody>
                        <?php
                        generador_general(get_post_meta(get_the_ID()), get_the_ID());
                        ?>
                    </tbody>
                </table>
            </div>
        </article>
        <?php
    } elseif (get_post_type() === 'carreras') {
        ?>
        <div class="muesta-individual-sin-registro">
            <?php
            generador_carreras($post);
            ?>
        </div>
        <?php
    }

endwhile;

get_footer();

function generador_general($para_mostrar, $el_id)
{
    foreach ($para_mostrar as $key => $items) {
        $prefijo = 'INSPT_SISTEMA_DE_INSCRIPCIONES_' . get_post_type($el_id) . '_';
        if (strpos($key, $prefijo) === 0) {
            $campo = str_replace($prefijo, '', $key);
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
                            generador_general($sub_meta, $item);
                            echo '</tbody></table>';
                        }
                    }
                } else {
                    foreach ($items as $item) {

                        $posible_json = json_decode($item);

                        $posible_url = (filter_var($item, FILTER_VALIDATE_URL) ? @get_headers($item) : '');

                        if (!empty($item)) {
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
                                if (!empty($posible_url)) {
                                    echo '<a href="' . esc_html($item) . '">' . esc_html($item) . '</a>';
                                } else {
                                    echo '<div>' . ($item) . '</div>';
                                }
                            }
                        } else {
                            echo '<td>' . '</td>';
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

function generador_carreras($post)
{
    $total_materias = array();
    $periodo_mayor = 0;
    ?>
    <img class="imagen-carrera"
        src="<?php echo esc_html(wp_get_attachment_image_url(get_post_meta($post->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_imagen_para_galeria', true))) ?>"
        alt="imagen-carrera">
    <div class="centrado">
        <h1 class="titulo-carrera">
            <?php echo get_the_title() ?>
        </h1>
        <h6 class="plan-carrera">Número de plan:
            <?php echo get_post_meta($post->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_numero_de_plan_de_la_carrera', true); ?>
        </h6>
        <h2 class="tipos-de-carrera">
            <?php echo get_the_title(get_post(get_post_meta($post->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_tipos_de_carrera', true))); ?>
        </h2>
    </div>
    <p class="descripcion-carrera">
        <?php echo esc_html(get_post_meta($post->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_descripcion_de_la_carrera', true)); ?>
    </p>
    <?php
    foreach (get_post_meta($post->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_profesional_en_condiciones_de_la_carrera', false) as $condicion) {
        ?>
        <p class="profesional-en-condiciones-de-la-carrera">
            <?php echo esc_html($condicion); ?>
        </p>
        <?php
    }
    ?>
    <a class="resolucion-ministerial"
        href="<?php echo esc_html(get_post_meta($post->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_resolucion_ministerial_de_la_carrera', true)); ?>">
        Resolución ministerial
    </a>
    <?php
    $reconocimiento_CABA = get_post_meta($post->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_reconocimiento_CABA', true);
    $reconocimiento_PBA = get_post_meta($post->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_reconocimiento_PBA', true);

    if (!empty($reconocimiento_CABA) || !empty($reconocimiento_CABA)) {
        ?>
        <p>Resoluciones de reconocimiento en AMBA:</p>
        <?php
        if (!empty($reconocimiento_CABA)) {
            ?>
            <a class="link carreras" href="<?php echo esc_html(get_post($reconocimiento_CABA)->guid) ?>">
                Reconocimiento CABA </a>
            <?php
        }
        if (!empty($reconocimiento_PBA)) {
            ?>
            <a class="link carreras" href="<?php echo esc_html(get_post($reconocimiento_PBA)->guid) ?>">
                Reconocimiento PBA </a>
            <?php
        }
    }
    foreach (get_post_meta(get_post_meta($post->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_planes_y_programas', true), 'INSPT_SISTEMA_DE_INSCRIPCIONES_planes_y_programas_materias', false) as $programa) {
        $sub_materia = array();
        $sub_codigo_materia = get_post_meta($programa, 'INSPT_SISTEMA_DE_INSCRIPCIONES_materias_codigo_de_materia', true);
        $sub_nombre_materia = get_post_meta($programa, 'INSPT_SISTEMA_DE_INSCRIPCIONES_materias_asginatura', true);
        $sub_periodo_y_hora = array();
        foreach (get_post_meta($programa, 'INSPT_SISTEMA_DE_INSCRIPCIONES_materias_periodo_en_que_aplica_horas', false) as $materias) {
            foreach (json_decode($materias) as $periodo_y_hora) {
                $sub_periodo_y_hora += array($periodo_y_hora->periodo_en_que_aplica => $periodo_y_hora->horas);
                if ($periodo_mayor < $periodo_y_hora->periodo_en_que_aplica) {
                    $periodo_mayor = $periodo_y_hora->periodo_en_que_aplica;
                }
            }

        }
        array_push($sub_materia, $sub_codigo_materia, $sub_nombre_materia, $sub_periodo_y_hora);

        array_push($total_materias, $sub_materia);
    }
    $horas_periodo = array();
    $horas_totales = 0;
    ?>
    <table class="tabla-materias">
        <tbody>
            <tr>
                <th colspan="<?php echo esc_html($periodo_mayor + 2) ?>">
                    <span>Período:
                        <?php
                        echo esc_html(get_post_meta(get_post_meta($post->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_planes_y_programas', true), 'INSPT_SISTEMA_DE_INSCRIPCIONES_planes_y_programas_tipo_de_cursada', true));
                        ?>
                    </span>
                </th>
            </tr>
            <tr>
                <th>
                    Código de materia
                </th>
                <th>
                    Nombre de la materia
                </th>
                <?php
                for ($contador_de_columnas = 1; $contador_de_columnas <= $periodo_mayor; $contador_de_columnas++) {
                    ?>
                    <th> Período N°
                        <?php
                        echo esc_html($contador_de_columnas);
                        ?>
                    </th>
                    <?php
                }
                ?>
            </tr>
            <?php
            foreach ($total_materias as $materia) {
                ?>
                <tr>
                    <td><?php echo esc_html($materia[0]); ?></td>
                    <td><?php echo esc_html($materia[1]); ?></td>
                    <?php
                    for ($contador_periodo = 1; $contador_periodo <= $periodo_mayor; $contador_periodo++) {
                        $horario = isset($materia[2][$contador_periodo]) ? $materia[2][$contador_periodo] : 0;
                        // Acumular horas por período
                        if (isset($horas_periodo[$contador_periodo])) {
                            $horas_periodo[$contador_periodo] += $horario;
                        } else {
                            $horas_periodo[$contador_periodo] = $horario;
                        }
                        // Acumular total general
                        $horas_totales += $horario;
                        ?>
                        <td><?php echo esc_html($horario !== 0 ? $horario : ''); ?></td>
                        <?php
                    }
                    ?>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="2"><span>Horas por período:</span>
                </td>
                <?php
                for ($contador_periodo = 1; $contador_periodo <= $periodo_mayor; $contador_periodo++) {
                    ?>
                    <td>
                        <?php
                        echo esc_html($horas_periodo[$contador_periodo]);
                        ?>
                    </td>
                    <?php
                }
                ?>
            </tr>
            <tr>
                <td colspan="2"><span>Horas totales:</span></td>
                <td colspan="<?php echo esc_html($periodo_mayor) ?>">
                    <span>
                        <?php
                        echo esc_html($horas_totales);
                        ?>
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
    <a class="link carreras"
        href="<?php echo esc_html(get_post(get_post_meta($post->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_correlatividades_de_la_carrera', true))->guid); ?>">
        Correlativas de la carrera </a>
    <div class="dropdown-group">
        <a href="#" class="dropdown-trigger horarios">Horarios ▼</a>
        <div class="dropdown-content">
            <a class="link horarios"
                href="<?php echo esc_url(get_post(get_post_meta($post->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_horarios_turno_manana_de_la_carrera', true))->guid); ?>">
                Turno Mañana
            </a>
            <a class="link horarios"
                href="<?php echo esc_url(get_post(get_post_meta($post->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_horarios_turno_tarde_de_la_carrera', true))->guid); ?>">
                Turno Tarde
            </a>
            <a class="link horarios"
                href="<?php echo esc_url(get_post(get_post_meta($post->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_horarios_turno_noche_de_la_carrera', true))->guid); ?>">
                Turno Noche
            </a>
        </div>
    </div>

    <div class="dropdown-group">
        <a href="#" class="dropdown-trigger mesas-de-examen">Mesas de Exámen ▼</a>
        <div class="dropdown-content">
            <a class="link mesas-de-examen"
                href="<?php echo esc_url(get_post(get_post_meta($post->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_mesas_de_examen_turno_manana_de_la_carrera', true))->guid); ?>">
                Turno Mañana
            </a>
            <a class="link mesas-de-examen"
                href="<?php echo esc_url(get_post(get_post_meta($post->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_mesas_de_examen_turno_tarde_de_la_carrera', true))->guid); ?>">
                Turno Tarde
            </a>
            <a class="link mesas-de-examen"
                href="<?php echo esc_url(get_post(get_post_meta($post->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_mesas_de_examen_turno_noche_de_la_carrera', true))->guid); ?>">
                Turno Noche
            </a>
        </div>
    </div>
    <p class="nombre-direccion-carrera">
        <?php echo esc_html(get_post_meta($post->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_nombre_de_la_direccion_de_la_carrera', true)); ?>
    </p>
    <p class="descripcion-direccion-carrera">
        <?php echo esc_html(get_post_meta($post->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_descripcion_de_la_direccion_de_la_carrera', true)); ?>
    </p>
    <p class="nombre-referente-carrera">
        <?php echo esc_html(get_post_meta($post->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_nombre_del_referente_de_laboratorio', true)); ?>
    </p>
    <p class="descripcion-referente-carrera">
        <?php echo esc_html(get_post_meta($post->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_descripcion_del_referente_de_laboratorio', true)); ?>
    </p>
    <p class="grado-academico">Grado académico:
        <?php echo esc_html(get_post_meta($post->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_grado_academico', true)); ?>
    </p>
    <p class="modalidad">Modalidad:
        <?php echo esc_html(get_post_meta($post->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_modalidad', true)); ?>
    </p>
    <div class="contactos">
        <p class="titulo-contactos">Contactanos a través de:</p>
        <div class="metodos-contacto">
            <p class="contacto">
                <?php echo esc_html(get_post_meta($post->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_mail_de_la_carrera', true)); ?>
            </p>
            <?php
            foreach (get_post_meta($post->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_carreras_consultas_a', false) as $contacto) {
                ?>
                <p class="contacto">
                    <?php echo esc_html($contacto); ?>
                </p>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
}