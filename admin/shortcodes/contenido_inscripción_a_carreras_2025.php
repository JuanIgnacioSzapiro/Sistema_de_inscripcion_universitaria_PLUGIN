<?php
function documentacion_inscripciones_a_carreras_2025()
{
    $carreras = obtener_carreras();

    echo '<pre>';
    echo print_r($carreras);
    echo '</pre>';

    ob_start();
    ?>
    <div class="contenedor-doc-inscripciones">
        <h1 class="subtitulo">Inscribite a tu carrera</h1>
        <h2 class="subtitulo espaciado">Trámite para realizar la inscripción</h2>
        <div class="muestra-carreras">
            <?php
            foreach ($carreras as $carrera) {
                ?>
                <p><?php echo esc_html($carrera) ?></p>
                <?php
            }
            ?>
        </div>
        <div class="contenedor-dividido">
            <div class="lado-izq-arr">
                <p>1- Completar el formulario de Preinscripción</p>
                <p>2- Presentar la documentación requerida en la sede </p>
            </div>
            <div class="lado-der-arr">
                <p>Para otros trámites y consultas</p>
            </div>
            <div class="lado-izq-ab">
                <button class="boton_link">Formulario de inscripción</button>
            </div>
            <div class="lado-der-ab">
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
        <div class="recuadrado">No se aceptará la inscripción sin alguno de requisitos mencionados.

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

function obtener_carreras()
{

    return array_map(function ($post) {
        return $post->post_title;
    }, get_posts(array(
            'post_type' => 'carreras',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'title',
            'order' => 'ASC'
        )));
}



add_shortcode('doc_insc_2025', 'documentacion_inscripciones_a_carreras_2025');