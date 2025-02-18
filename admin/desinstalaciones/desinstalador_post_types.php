<?php
require_once dirname(__FILE__) . '/../post_type/generador_post_type.php';

function desinstalar_post_types()
{
    $carreras = new TipoDePost();
    $preinscriptos = new TipoDePost();

    $carreras->set_plural('carreras');

    foreach (array($carreras, $preinscriptos) as $objeto) {
        $objeto->deregistrar_post_type();
        $objeto->borrar_todos_los_post();
    }
}