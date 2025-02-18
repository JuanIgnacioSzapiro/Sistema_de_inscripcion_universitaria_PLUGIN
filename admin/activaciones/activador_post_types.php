<?php //activador_post_types.php
require_once dirname(__FILE__) . '/../post_type/generador_post_type.php';
require_once dirname(__FILE__) . '/../post_type/mis_post_type/generar_post_type_carreras.php';


function activar_post_types()
{
    $carreras = new CarreraTipoDePost('carrera', 'carreras', true, 'INSPT_SISTEMA_DE_INSCRIPCIONES');
    $carreras->registrar_post_type();
}