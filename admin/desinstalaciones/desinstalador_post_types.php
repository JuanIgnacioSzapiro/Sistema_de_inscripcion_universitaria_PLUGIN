<?php
require_once dirname(__FILE__) . '/../post_type/generador_post_type.php';

function desinstalar_post_types()
{
    $post = array(
        new CaracteristicasBasicasPostType('carreras'),
        new CaracteristicasBasicasPostType('tipos_de_carrera'),
        new CaracteristicasBasicasPostType('materias'),
        new CaracteristicasBasicasPostType('planes_y_programas'),
        new CaracteristicasBasicasPostType('doc'), 
        new CaracteristicasBasicasPostType('doc_total'), 
        new CaracteristicasBasicasPostType('pre_form_ingreso'), 
        new CaracteristicasBasicasPostType('form_ingreso'), 
        new CaracteristicasBasicasPostType('links_preinscriptos'), 
    );

    if (!empty($post)) {
        foreach ($post as $objeto) {
            $objeto->deregistrar_post_type();
            $objeto->borrar_todos_los_post();
        }
    }
}