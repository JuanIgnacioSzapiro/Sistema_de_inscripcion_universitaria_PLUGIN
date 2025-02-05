<?php
require_once dirname(__FILE__) . '/../post_type/generador_post_type.php';
require_once dirname(__FILE__) . '/../post_type/generar_post_type_carreras.php';
require_once dirname(__FILE__) . '/../post_type/generar_post_type_preinscriptos.php';


function activar_post_types()
{
    foreach (array(obtener_informacion_post_type_carreras(), obtener_informacion_post_type_preinscriptos()) as $objeto) {
        $objeto->registrar_post_type();
    }
}