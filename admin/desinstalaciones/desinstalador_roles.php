<?php
require_once dirname(__FILE__) . '/../roles/generador_rol.php';

function desinstalar_roles()
{
    $supra_apoyo_de_alumno = new TipoDeRol();
    $supra_coordinador = new TipoDeRol();
    $preinscripto = new TipoDeRol();
    $supra_profesor = new TipoDeRol();
    $apoyo_de_alumno = new TipoDeRol();
    $coordinador = new TipoDeRol();
    $profesor = new TipoDeRol();

    $supra_apoyo_de_alumno->set_id('supra_apoyo_de_alumno');
    $apoyo_de_alumno->set_id('apoyo_de_alumno');
    $supra_coordinador->set_id('supra_coordinador');
    $coordinador->set_id('coordinador');
    $preinscripto->set_id('preinscripto');
    $supra_profesor->set_id('supra_profesor');
    $profesor->set_id('profesor');

    foreach (array($supra_apoyo_de_alumno, $apoyo_de_alumno, $supra_coordinador, $coordinador, $supra_profesor, $profesor, $preinscripto, ) as $objeto) {
        $objeto->borrar_rol();
    }

    $administrador = get_role('administrator');

    $administrador->remove_cap('edit_carreras');
    $administrador->remove_cap('read_carreras');
    $administrador->remove_cap('delete_carreras');
    $administrador->remove_cap('edit_multiples_carreras');
    $administrador->remove_cap('edit_others_multiples_carreras');
    $administrador->remove_cap('publish_multiples_carreras');
    $administrador->remove_cap('read_private_multiples_carreras');
    $administrador->remove_cap('delete_multiples_carreras');
    $administrador->remove_cap('delete_private_multiples_carreras');
    $administrador->remove_cap('delete_published_multiples_carreras');
    $administrador->remove_cap('delete_others_multiples_carreras');
    $administrador->remove_cap('edit_private_multiples_carreras');
    $administrador->remove_cap('edit_published_multiples_carreras');
    $administrador->remove_cap('create_multiples_carreras');

    $administrador->remove_cap('edit_preinscriptos');
    $administrador->remove_cap('read_preinscriptos');
    $administrador->remove_cap('delete_preinscriptos');
    $administrador->remove_cap('edit_multiples_preinscriptos');
    $administrador->remove_cap('edit_others_multiples_preinscriptos');
    $administrador->remove_cap('publish_multiples_preinscriptos');
    $administrador->remove_cap('read_private_multiples_preinscriptos');
    $administrador->remove_cap('delete_multiples_preinscriptos');
    $administrador->remove_cap('delete_private_multiples_preinscriptos');
    $administrador->remove_cap('delete_published_multiples_preinscriptos');
    $administrador->remove_cap('delete_others_multiples_preinscriptos');
    $administrador->remove_cap('edit_private_multiples_preinscriptos');
    $administrador->remove_cap('edit_published_multiples_preinscriptos');
    $administrador->remove_cap('create_multiples_preinscriptos');

}
