<?php
require_once dirname(__FILE__) . '/admin/post_type/generador_post_type.php';

function desactivar_plugin()
{
    desactivar_post_types();

    desactivar_roles();

    flush_rewrite_rules(); // limpia permalinks
}

function desactivar_post_types()
{
    $apoyo_de_alumnos = new tipo_de_post();
    $carreras = new tipo_de_post();
    $coordinadores = new tipo_de_post();
    $preinscriptos = new tipo_de_post();
    $profesores = new tipo_de_post();

    $apoyo_de_alumnos->set_id('apoyo_de_alumnos');
    $carreras->set_id('carreras');
    $coordinadores->set_id('coordinadores');
    $preinscriptos->set_id('preinscriptos');
    $profesores->set_id('profesores');

    foreach (array($apoyo_de_alumnos, $carreras, $coordinadores, $preinscriptos, $profesores) as $objeto) {
        $objeto->deregistrar_post_type();
    }
}

function desactivar_roles()
{
    $supra_apoyo_de_alumno = new tipo_de_rol();
    $supra_coordinador = new tipo_de_rol();
    $preinscripto = new tipo_de_rol();
    $supra_profesor = new tipo_de_rol();
    $apoyo_de_alumno = new tipo_de_rol();
    $coordinador = new tipo_de_rol();
    $profesor = new tipo_de_rol();

    $supra_apoyo_de_alumno->set_id('supra_apoyo_de_alumno');
    $supra_coordinador->set_id('supra_coordinador');
    $preinscripto->set_id('preinscripto');
    $supra_profesor->set_id('supra_profesor');
    $apoyo_de_alumno->set_id('apoyo_de_alumno');
    $coordinador->set_id('coordinador');
    $profesor->set_id('profesor');
}
