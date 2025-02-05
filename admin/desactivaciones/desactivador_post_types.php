<?php
require_once dirname(__FILE__) . '/../post_type/generador_post_type.php';
function desactivar_post_types()
{
    $carreras = new TipoDePost();
    $preinscriptos = new TipoDePost();

    $carreras->set_id('carreras');
    $preinscriptos->set_id('preinscriptos');

    foreach (array($carreras, $preinscriptos) as $objeto) {
        $objeto->deregistrar_post_type();
    }
}