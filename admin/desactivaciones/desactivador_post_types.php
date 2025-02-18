<?php
require_once dirname(__FILE__) . '/../post_type/generador_post_type.php';
function desactivar_post_types()
{
    $carreras = new TipoDePost('carreras');

    foreach (array($carreras) as $objeto) {
        $objeto->deregistrar_post_type();
    }
}