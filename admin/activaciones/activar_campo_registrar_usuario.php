<?php
require_once dirname(__FILE__) . '/../registrar_usuarios/generar_campo_registro.php';
require_once dirname(__FILE__) . '/../registrar_usuarios/un_campo_personalizado.php';

// Crear campos al activar el plugin
function activar_campo_registrar_usuario()
{
    $campos = array(
        new CampoIndividual('last_name', 'Apellidos'),
        new CampoIndividual('first_name', 'Nombres'),
        new CampoIndividual('dni', 'DNI', false, 'int'),
    );

    new CamposPersonalizados($campos, array('last_name', 'dni'));
}