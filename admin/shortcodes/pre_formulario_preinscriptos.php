<?php
// En tu archivo functions.php o en un plugin personalizado

// 1. Crear el shortcode
add_shortcode('pre_formulario_preinscriptos', 'pre_formulario_preinscriptos_shortcode');
function pre_formulario_preinscriptos_shortcode()
{
    $preguntas = array(
        new CampoTexto(
            'dni',
            'DNI',
            '11.111.111',
            'Se ingresa el DNI',
        ),
        new CampoTexto(
            'apellidos',
            'Apellidos',
            'Doe',
            'Se ingresan los apellidos',
        ),
        new CampoTexto(
            'nombres',
            'Nombres',
            'John',
            'Se ingresan los nombres',
        ),
        new CampoTexto(
            'mails_de_contacto',
            'Mails de contacto',
            'john.doe@gmail.com',
            'Se ingresan los mails',
            true
        ),
        new CampoDropDownTipoPost(
            'carreras',
            'Carreras a la que está inscripta',
            'carreras',
            'Se selecciona las carrera, previamente creada y publicada',
            true
        ),
    );

    ob_start();
    ?>
    <div class="formulario">
        <h2>INGRESO 2025</h2>
        <p>Bienvenido/a al <b>INSPT-UTN</b></p>
        <p>A continuación, te brindamos Información sobre la <b>oferta académica del INSPT</b></p>
        <p>Ingresa a <a href="http://localhost/wordpress/index.php/demostracion-shortcodes/">http://localhost/wordpress/index.php/demostracion-shortcodes/</a> y consulta la carrera de tu interés (turnos, planes de estudios, entre otros)</p>
        <b>Acerca de la Preinscripción a las carreras del INSPT-UTN</b>
        <p>• Completa los campos requeridos a continuación (asegúrate de ingresar correctamente el mail ya que allí recibirás información para continuar el trámite).</p>
        <p>• Sigue las instrucciones que recibas por correo electrónico. No olvides revisar la carpeta de SPAM. En caso de no recibirlo, no dudes en comunicarte con nosotros a ingreso2025@inspt.utn.edu.ar .</p>

        <?php
        foreach ($preguntas as $pregunta) {
            ?>
            <form class="en-meta-box" method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <?php
                $pregunta->generar_fragmento_html_formulario($GLOBALS['prefijo_variables_sql']);
                ?>
            </form>
            <?php
        }
        ?>
        <button type="submit" class="button">Inicir preinscripción</button>
    </div>
    <?php
    return ob_get_clean();
}