<?php
require_once dirname(__FILE__) . '/../post_type/generador_post_type.php';
function desactivar_post_types()
{
    $post = array(
        // new TipoDePost('carreras'),
        // new TipoDePost('tipos_de_carrera'),
        // new TipoDePost('materias'),
        // new TipoDePost('planes_y_programas'),
        // new TipoDePost('documentacion'), 
    );

    if (!empty($post)) {
        foreach ($post as $objeto) {
            $objeto->deregistrar_post_type();
        }
    }
}