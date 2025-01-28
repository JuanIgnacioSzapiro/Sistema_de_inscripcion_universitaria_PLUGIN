<?php
require_once dirname(__FILE__) . '/admin/post_type/post_type_carreras.php';
require_once dirname(__FILE__) . '/admin/post_type/post_type_coordinadores.php';
require_once dirname(__FILE__) . '/admin/post_type/post_type_preinscriptos.php';
require_once dirname(__FILE__) . '/admin/post_type/post_type_profesores.php';
require_once dirname(__FILE__) . '/admin/post_type/post_type_apoyo_de_alumnos.php';


function activar_plugin()
{
    $apoyo_de_alumnos = new apoyo_de_alumnos();
    $carreras = new carrera();
    $coordinadores = new coordinador();
    $preinscriptos = new preinscripto();
    $profesores = new profesor();

    flush_rewrite_rules(); // limpia permalinks
}