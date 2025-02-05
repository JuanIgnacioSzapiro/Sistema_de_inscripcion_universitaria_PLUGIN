<?php
require_once dirname(__FILE__) . '/../roles/generador_rol.php';

function activar_roles()
{
    $supra_apoyo_de_alumno = new TipoDeRol();
    $apoyo_de_alumno = new TipoDeRol();

    $supra_coordinador = new TipoDeRol();
    $coordinador = new TipoDeRol();

    $preinscripto = new TipoDeRol();

    $supra_profesor = new TipoDeRol();
    $profesor = new TipoDeRol();

    $supra_apoyo_de_alumno->set_id('supra_apoyo_de_alumno');
    $supra_apoyo_de_alumno->set_nombre_para_mostrar('Supra Apoyo de Alumno');
    $supra_apoyo_de_alumno->set_habilidades(array('read' => true));

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

    $roles = array($supra_apoyo_de_alumno, $apoyo_de_alumno, $supra_coordinador, $coordinador, $supra_profesor, $profesor, $preinscripto, );

    foreach ($roles as $objeto) {
        $objeto->agregar_rol();
    }

    activar_habilidades($roles);
}

function activar_habilidades($roles)
{
    array_push($roles, 'administrator');

    foreach ($roles as $rol) {
        $rol_obtenido = get_role(is_a($rol, 'TipoDeRol') ? $rol->get_id() : $rol);
        switch ($rol_obtenido->name) {
            case 'administrator':
                $rol_obtenido->add_cap('edit_carreras');
                $rol_obtenido->add_cap('read_carreras');
                $rol_obtenido->add_cap('delete_carreras');
                $rol_obtenido->add_cap('edit_multiples_carreras');
                $rol_obtenido->add_cap('edit_others_multiples_carreras');
                $rol_obtenido->add_cap('publish_multiples_carreras');
                $rol_obtenido->add_cap('read_private_multiples_carreras');
                $rol_obtenido->add_cap('delete_multiples_carreras');
                $rol_obtenido->add_cap('delete_private_multiples_carreras');
                $rol_obtenido->add_cap('delete_published_multiples_carreras');
                $rol_obtenido->add_cap('delete_others_multiples_carreras');
                $rol_obtenido->add_cap('edit_private_multiples_carreras');
                $rol_obtenido->add_cap('edit_published_multiples_carreras');
                $rol_obtenido->add_cap('create_multiples_carreras');

                $rol_obtenido->add_cap('edit_preinscriptos');
                $rol_obtenido->add_cap('read_preinscriptos');
                $rol_obtenido->add_cap('delete_preinscriptos');
                $rol_obtenido->add_cap('edit_multiples_preinscriptos');
                $rol_obtenido->add_cap('edit_others_multiples_preinscriptos');
                $rol_obtenido->add_cap('publish_multiples_preinscriptos');
                $rol_obtenido->add_cap('read_private_multiples_preinscriptos');
                $rol_obtenido->add_cap('delete_multiples_preinscriptos');
                $rol_obtenido->add_cap('delete_private_multiples_preinscriptos');
                $rol_obtenido->add_cap('delete_published_multiples_preinscriptos');
                $rol_obtenido->add_cap('delete_others_multiples_preinscriptos');
                $rol_obtenido->add_cap('edit_private_multiples_preinscriptos');
                $rol_obtenido->add_cap('edit_published_multiples_preinscriptos');
                
                break;

            case 'supra_apoyo_de_alumno':
                $rol_obtenido->add_cap('edit_preinscriptos');
                $rol_obtenido->add_cap('read_preinscriptos');
                $rol_obtenido->add_cap('delete_preinscriptos');
                $rol_obtenido->add_cap('edit_multiples_preinscriptos');
                $rol_obtenido->add_cap('edit_others_multiples_preinscriptos');
                $rol_obtenido->add_cap('publish_multiples_preinscriptos');
                $rol_obtenido->add_cap('read_private_multiples_preinscriptos');
                $rol_obtenido->add_cap('delete_multiples_preinscriptos');
                $rol_obtenido->add_cap('delete_private_multiples_preinscriptos');
                $rol_obtenido->add_cap('delete_published_multiples_preinscriptos');
                $rol_obtenido->add_cap('delete_others_multiples_preinscriptos');
                $rol_obtenido->add_cap('edit_private_multiples_preinscriptos');
                $rol_obtenido->add_cap('edit_published_multiples_preinscriptos');
                
                break;

            case 'apoyo_de_alumno':
                $rol_obtenido->add_cap('edit_preinscriptos');
                $rol_obtenido->add_cap('read_preinscriptos');
                $rol_obtenido->add_cap('delete_preinscriptos');
                $rol_obtenido->add_cap('edit_multiples_preinscriptos');
                $rol_obtenido->add_cap('edit_others_multiples_preinscriptos');
                $rol_obtenido->add_cap('publish_multiples_preinscriptos');
                $rol_obtenido->add_cap('read_private_multiples_preinscriptos');
                $rol_obtenido->add_cap('delete_multiples_preinscriptos');
                $rol_obtenido->add_cap('delete_private_multiples_preinscriptos');
                $rol_obtenido->add_cap('delete_published_multiples_preinscriptos');
                $rol_obtenido->add_cap('delete_others_multiples_preinscriptos');
                $rol_obtenido->add_cap('edit_private_multiples_preinscriptos');
                $rol_obtenido->add_cap('edit_published_multiples_preinscriptos');
                
                break;

            case 'supra_coordinador':
                $rol_obtenido->add_cap('edit_carreras');
                $rol_obtenido->add_cap('read_carreras');
                $rol_obtenido->add_cap('delete_carreras');
                $rol_obtenido->add_cap('edit_multiples_carreras');
                $rol_obtenido->add_cap('edit_others_multiples_carreras');
                $rol_obtenido->add_cap('publish_multiples_carreras');
                $rol_obtenido->add_cap('read_private_multiples_carreras');
                $rol_obtenido->add_cap('delete_multiples_carreras');
                $rol_obtenido->add_cap('delete_private_multiples_carreras');
                $rol_obtenido->add_cap('delete_published_multiples_carreras');
                $rol_obtenido->add_cap('delete_others_multiples_carreras');
                $rol_obtenido->add_cap('edit_private_multiples_carreras');
                $rol_obtenido->add_cap('edit_published_multiples_carreras');
                $rol_obtenido->add_cap('create_multiples_carreras');

                $rol_obtenido->add_cap('edit_preinscriptos');
                $rol_obtenido->add_cap('read_preinscriptos');
                $rol_obtenido->add_cap('delete_preinscriptos');
                $rol_obtenido->add_cap('edit_multiples_preinscriptos');
                $rol_obtenido->add_cap('edit_others_multiples_preinscriptos');
                $rol_obtenido->add_cap('publish_multiples_preinscriptos');
                $rol_obtenido->add_cap('read_private_multiples_preinscriptos');
                $rol_obtenido->add_cap('delete_multiples_preinscriptos');
                $rol_obtenido->add_cap('delete_private_multiples_preinscriptos');
                $rol_obtenido->add_cap('delete_published_multiples_preinscriptos');
                $rol_obtenido->add_cap('delete_others_multiples_preinscriptos');
                $rol_obtenido->add_cap('edit_private_multiples_preinscriptos');
                $rol_obtenido->add_cap('edit_published_multiples_preinscriptos');
                
                break;

            case 'coordinador':
                $rol_obtenido->add_cap('edit_carreras');
                $rol_obtenido->add_cap('read_carreras');
                $rol_obtenido->add_cap('delete_carreras');
                $rol_obtenido->add_cap('edit_multiples_carreras');
                $rol_obtenido->add_cap('edit_others_multiples_carreras');
                $rol_obtenido->add_cap('publish_multiples_carreras');
                $rol_obtenido->add_cap('read_private_multiples_carreras');
                $rol_obtenido->add_cap('delete_multiples_carreras');
                $rol_obtenido->add_cap('delete_private_multiples_carreras');
                $rol_obtenido->add_cap('delete_published_multiples_carreras');
                $rol_obtenido->add_cap('delete_others_multiples_carreras');
                $rol_obtenido->add_cap('edit_private_multiples_carreras');
                $rol_obtenido->add_cap('edit_published_multiples_carreras');
                $rol_obtenido->add_cap('create_multiples_carreras');

                $rol_obtenido->add_cap('edit_preinscriptos');
                $rol_obtenido->add_cap('read_preinscriptos');
                $rol_obtenido->add_cap('delete_preinscriptos');
                $rol_obtenido->add_cap('edit_multiples_preinscriptos');
                $rol_obtenido->add_cap('edit_others_multiples_preinscriptos');
                $rol_obtenido->add_cap('publish_multiples_preinscriptos');
                $rol_obtenido->add_cap('read_private_multiples_preinscriptos');
                $rol_obtenido->add_cap('delete_multiples_preinscriptos');
                $rol_obtenido->add_cap('delete_private_multiples_preinscriptos');
                $rol_obtenido->add_cap('delete_published_multiples_preinscriptos');
                $rol_obtenido->add_cap('delete_others_multiples_preinscriptos');
                $rol_obtenido->add_cap('edit_private_multiples_preinscriptos');
                $rol_obtenido->add_cap('edit_published_multiples_preinscriptos');
                
                break;

            case 'preinscripto':

                break;

            case 'supra_profesor':
                $rol_obtenido->add_cap('edit_multiples_preinscriptos');
                $rol_obtenido->add_cap('edit_others_multiples_preinscriptos');
                $rol_obtenido->add_cap('read_private_multiples_preinscriptos');
                $rol_obtenido->add_cap('edit_private_multiples_preinscriptos');
                $rol_obtenido->add_cap('edit_published_multiples_preinscriptos');
                
                break;

            case 'profesor':
                $rol_obtenido->add_cap('edit_multiples_preinscriptos');
                $rol_obtenido->add_cap('edit_others_multiples_preinscriptos');
                $rol_obtenido->add_cap('read_private_multiples_preinscriptos');
                $rol_obtenido->add_cap('edit_private_multiples_preinscriptos');
                $rol_obtenido->add_cap('edit_published_multiples_preinscriptos');
                
                break;
        }
    }
}