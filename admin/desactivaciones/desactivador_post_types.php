<?php
require_once dirname(__FILE__) . '/../post_type/generador_post_type.php';
function desactivar_post_types()
{
    $post = array(
        new CaracteristicasBasicasPostType('carreras'),
        new CaracteristicasBasicasPostType('tipos_de_carrera'),
        new CaracteristicasBasicasPostType('materias'),
        new CaracteristicasBasicasPostType('planes_y_programas'),
        new CaracteristicasBasicasPostType('documentacion'), 
    );

    if (!empty($post)) {
        foreach ($post as $objeto) {
            $objeto->deregistrar_post_type();
        }
    }
}