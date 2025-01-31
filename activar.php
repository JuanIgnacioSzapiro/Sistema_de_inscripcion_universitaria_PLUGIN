<?php
require_once dirname(__FILE__) . '/admin/post_type/generador_post_type.php';
require_once dirname(__FILE__) . '/admin/roles/generador_rol.php';

function activar_plugin()
{
    activar_post_types();

    activar_roles();

    flush_rewrite_rules(); // limpia permalinks
}

function activar_post_types()
{
    $apoyo_de_alumnos = new tipo_de_post();
    $apoyo_de_alumnos->set_id('apoyo_de_alumnos');
    $apoyo_de_alumnos->set_caracteristicas(array(
        'public' => true,
        'label' => 'Apoyo de alumnos',
        'menu_icon' => 'dashicons-groups',
        'menu_position' => 101,
    ));
    $carreras = new tipo_de_post();
    $carreras->set_id('carreras');
    $carreras->set_caracteristicas(array(
        'public' => true,
        'label' => 'Carreras',
        'menu_icon' => 'dashicons-admin-multisite',
        'menu_position' => 102,
    ));
    $coordinadores = new tipo_de_post();
    $coordinadores->set_id('coordinadores');
    $coordinadores->set_caracteristicas(array(
        'public' => true,
        'label' => 'Coordinadores',
        'menu_icon' => 'dashicons-networking',
        'menu_position' => 103,
    ));
    $preinscriptos = new tipo_de_post();
    $preinscriptos->set_id('preinscriptos');
    $preinscriptos->set_caracteristicas(array(
        'public' => true,
        'label' => 'Preinscriptos',
        'menu_icon' => 'dashicons-id-alt',
        'menu_position' => 104,
    ));
    $profesores = new tipo_de_post();
    $profesores->set_id('profesores');
    $profesores->set_caracteristicas(array(
        'public' => true,
        'label' => 'Profesores',
        'menu_icon' => 'dashicons-welcome-learn-more',
        'menu_position' => 105,
    ));

    foreach (array($apoyo_de_alumnos, $carreras, $coordinadores, $preinscriptos, $profesores) as $objeto) {
        $objeto->registrar_post_type();
    }
}

function activar_roles()
{
    $supra_apoyo_de_alumno = new tipo_de_rol();
    $apoyo_de_alumno = new tipo_de_rol();

    $supra_coordinador = new tipo_de_rol();
    $coordinador = new tipo_de_rol();

    $preinscripto = new tipo_de_rol();

    $supra_profesor = new tipo_de_rol();
    $profesor = new tipo_de_rol();

    $supra_apoyo_de_alumno->set_id('supra_apoyo_de_alumno');
    $supra_apoyo_de_alumno->set_nombre_para_mostrar('Supra Apoyo de Alumno');
    $supra_apoyo_de_alumno->set_habilidades(array('read' => true, 'upload_files' => false, 'edit_files' => false));

    $apoyo_de_alumno->set_id('apoyo_de_alumno');
    $apoyo_de_alumno->set_nombre_para_mostrar('Apoyo de Alumno');
    $apoyo_de_alumno->set_habilidades(array('read' => true));

    $supra_coordinador->set_id('supra_coordinador');
    $supra_coordinador->set_nombre_para_mostrar('Supra Coordinador');
    $supra_coordinador->set_habilidades(array('read' => true));

    $coordinador->set_id('coordinador');
    $coordinador->set_nombre_para_mostrar('Coordinador');
    $coordinador->set_habilidades(array('read' => true));

    $preinscripto->set_id('preinscripto');
    $preinscripto->set_nombre_para_mostrar('Preinscripto');
    $preinscripto->set_habilidades(array('read' => true));

    $supra_profesor->set_id('supra_profesor');
    $supra_profesor->set_nombre_para_mostrar('Supra Profesor');
    $supra_profesor->set_habilidades(array('read' => true));

    $profesor->set_id('profesor');
    $profesor->set_nombre_para_mostrar('Profesor');
    $profesor->set_habilidades(array('read' => true));

    foreach (array($supra_apoyo_de_alumno, $apoyo_de_alumno, $supra_coordinador, $coordinador, $supra_profesor, $profesor, $preinscripto, ) as $objeto) {
        $objeto->agregar_rol();
    }
}