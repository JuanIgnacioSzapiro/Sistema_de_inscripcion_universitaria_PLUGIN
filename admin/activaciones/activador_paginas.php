<?php
require_once dirname(__FILE__) . '/../paginador/paginador.php';

function activar_paginas()
{
    $title_of_the_page = array(
        'Visualizador de carreras' => "[mostrar_galeria post_type='carreras']",
        'Documentación para la inscripción a carreras 2025' => "[doc_insc_2025]",
        'Pre formulario de pre inscripción 2025' => "[pre_formulario_preinscriptos]",
        'Inicio de sesión' => "[inicio_sesion_manejo_preinscriptos]",
        'Menu de inicio' => '[menu_de_inicio]'
    );

    foreach ($title_of_the_page as $key => $item) {
        $paginador = new Paginador($key, $item);
        $objPage = $paginador->new_get_page_by_title($key);
        if (empty($objPage)) {
            $paginador->create_page($key, $item);
        }
    }
}

