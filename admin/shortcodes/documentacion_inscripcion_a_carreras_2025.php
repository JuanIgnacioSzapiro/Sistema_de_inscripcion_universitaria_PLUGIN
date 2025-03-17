<?php
function documentacion_inscripciones_a_carreras_2025()
{
    $carreras = obtener_post_type('carreras');
    $documentaciones = obtener_post_type('documentacion');


    ob_start();
    ?>
    <div class="contenedor-doc-inscripciones">
        <h1 class="subtitulo">Inscribite a tu carrera</h1>
        <div class="<?php echo esc_html((count($carreras) != 1) ? 'muestra-carreras' : 'muestra-carreras-solo') ?>">
            <?php
            foreach ($carreras as $carrera) {
                ?>
                <a href="<?php echo esc_html($carrera->guid) ?>"><?php echo esc_html($carrera->post_title) ?></a>
                <?php
            }
            ?>
        </div>
        <h2 class="subtitulo espaciado">Trámite para realizar la inscripción</h2>
        <div class="contenedor-dividido">
            <div class="lado-izq">
                <p>1- Completar el formulario de Preinscripción</p>
                <p>2- Presentar la documentación requerida en la sede </p>
                <button class="boton_link">Formulario de inscripción</button>
            </div>
            <div class="lado-der">
                <p>Para otros trámites y consultas</p>
                <button class="boton_link">Trámites y consultas</button>
            </div>

            </p>
        </div>
        <h2 class="subtitulo espaciado">Preguntas Frecuentes</h2>
        <div class="contenedor-dividido">
            <div class="lado-izq">
                <p class="pregunta">¿En qué fechas puedo presentar la documentación?</p>
                <p>>Primer período de 5/8/2024 al 13/12/2024</p>
                <p>>Segundo período de 27/01/2025 al 28/02/2025</p>
                <p>Ver requisitos según el tipo de ingreso de cada carrera</p>
            </div>
            <div class="lado-der">
                <p class="pregunta">¿Cómo es la Modalidad de cursado y el costo de las Tecnicaturas y Profesorados el INSPT?
                </p>
                <p>Presencial (se requiere el 75 % de asistencia) y son carreras NO aranceladas</p>
                <p class="pregunta">¿Dónde se presenta la documentación?</p>
                <p>Departamento de Alumnos (planta baja, sede Triunvirato 3174, CABA) de 9 a 20hs.</p>
            </div>
        </div>
        <div class="recuadrado espaciado">Aclaración: Si completaste la inscripción años anteriores (entrega de
            documentación) NO es
            necesario que te
            inscribas otra vez. Comunicate vía mail a deptoalumnos@inspt.utn.edu.ar
        </div>
        <h2 class="subtitulo espaciado">Documentación Requerida</h2>
        <div class="muestra-carreras-solo">
            <?php
            foreach ($documentaciones as $documentacion) {
                $carreras_documento = array_map(function ($item) {
                    return get_post($item);
                }, get_post_meta($documentacion->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_documentacion_carreras', false));
                $documentaciones = get_post_meta($documentacion->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_documentacion_documentacion_necesaria', false);
                $tipo_ingreso = get_post_meta($documentacion->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_documentacion_tipo_de_ingreso', true);
                $costos = get_post_meta($documentacion->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_documentacion_costos', true);
                $condiciones_asistencia = get_post_meta($documentacion->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_documentacion_condiciones_de_asistencia', true);
                $equivalencias = get_post_meta($documentacion->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_documentacion_equivalencias', false);
                $modelos_examen = get_post_meta($documentacion->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_documentacion_modelos_de_examen', false);
                $condiciones_ingreso = get_post_meta($documentacion->ID, 'INSPT_SISTEMA_DE_INSCRIPCIONES_documentacion_condiciones_de_ingreso', false);
                ?>
                <div class="carrera">
                    <?php
                    $max = count($carreras_documento);
                    foreach ($carreras_documento as $key => $carrera_documento) {
                        ?>
                        <a href="<?php echo esc_html($carrera_documento->guid) ?>">
                            <h4><?php echo esc_html($carrera_documento->post_title)?></h4>
                        </a>
                        <?php
                        echo (($key < $max - 1) ? ('<h4>&darr;</h4>') : '')
                        ?>
                        <?php
                    }
                    if (!empty($documentaciones)) {
                        ?>
                        <p id="documentaciones" class="subtitulo-mostrado">Documentación necesaria para la inscripción</p>
                        <?php
                        foreach ($documentaciones as $key => $documentacion) {
                            ?>
                            <p id="documentacion-<?php echo esc_html($key) ?>" class="escondido"><?php echo esc_html($documentacion) ?>
                            </p>
                            <?php
                        }
                    }
                    if (!empty($tipo_ingreso)) {
                        ?>
                        <p id="tipo_ingreso" class="subtitulo-mostrado">Tipo de ingreso</p>
                        <p id="contenido-tipo_ingreso" class="escondido"><?php echo esc_html(the_attachment_link($tipo_ingreso)) ?>
                        </p>
                        <?php
                    }
                    if (!empty($costos)) {
                        ?>
                        <p id="costos" class="subtitulo-mostrado">Costos</p>
                        <p id="costo" class="escondido"><?php echo esc_html($costos) ?></p>
                        <?php
                    }
                    if (!empty($condiciones_asistencia)) {
                        ?>
                        <p id="condiciones_asistencia" class="subtitulo-mostrado">Condiciones de asistencia</p>
                        <p id="condicion_asistencia" class="escondido"><?php echo esc_html($condiciones_asistencia) ?></p>
                        <?php
                    }
                    if (!empty($equivalencias)) {
                        ?>
                        <p id="equivalencias" class="subtitulo-mostrado">Equivalencias</p>
                        <?php
                        foreach ($equivalencias as $key => $equivalencia) {
                            ?>
                            <p id="equivalencia-<?php echo esc_html($key) ?>" class="escondido"><?php echo esc_html($equivalencia) ?>
                            </p>
                            <?php
                        }
                    }
                    if (!empty($modelos_examen)) {
                        ?>
                        <p id="modelos_examen" class="subtitulo-mostrado">Modelos de examen</p>
                        <?php
                        foreach ($modelos_examen as $key => $modelo_examen) {
                            ?>
                            <p id="modelo_examen-<?php echo esc_html($key) ?>" class="escondido">
                                <?php echo esc_html(the_attachment_link($modelo_examen)) ?>
                            </p>
                            <?php
                        }
                    }
                    if (!empty($condiciones_ingreso)) {
                        ?>
                        <p id="condiciones_ingreso" class="subtitulo-mostrado">Condiciones de ingreso</p>
                        <?php
                        foreach ($condiciones_ingreso as $condicion_ingreso) {
                            ?>
                            <p id="condicion_ingreso-<?php echo esc_html($key) ?>" class="escondido">
                                <?php echo esc_html($condicion_ingreso) ?>
                            </p>
                            <?php
                        }
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="recuadrado">
            No se aceptará la inscripción sin alguno de requisitos mencionados.
            La vacante queda reservada frente la presentación de documentación y supeditada a disponibilidad de la carrera.
            Si posee certificado de discapacidad debe presentar constancia.
            Alumnos que hayan completado la inscripción años anteriores NO será necesario que presenten nuevamente la
            documentación. Comunicarse vía mail a deptoalumnos@inspt.utn.edu.ar
        </div>
        <div>
            <h2 class="subtitulo espaciado">Otras consultas</h2>
            <p>Consultas generales sobre la inscripción y el ingreso</p>
            <p>Cuestiones académicas de las carreras</p>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

function obtener_post_type($id_post_type)
{

    return get_posts(array(
        'post_type' => $id_post_type,
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'orderby' => 'title',
        'order' => 'ASC'
    ));
}



add_shortcode('doc_insc_2025', 'documentacion_inscripciones_a_carreras_2025');