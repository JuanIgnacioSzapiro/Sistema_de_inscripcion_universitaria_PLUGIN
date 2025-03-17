<?php
require_once dirname(__FILE__) . '/../roles/generador_rol.php';
require_once dirname(__FILE__) . '/../post_type/generador_post_type.php';
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

    $apoyo_de_alumno->set_id('apoyo_de_alumno');
    $apoyo_de_alumno->set_nombre_para_mostrar('Apoyo de Alumno');

    $supra_coordinador->set_id('supra_coordinador');
    $supra_coordinador->set_nombre_para_mostrar('Supra Coordinador');

    $coordinador->set_id('coordinador');
    $coordinador->set_nombre_para_mostrar('Coordinador');

    $preinscripto->set_id('preinscripto');
    $preinscripto->set_nombre_para_mostrar('Preinscripto');

    $supra_profesor->set_id('supra_profesor');
    $supra_profesor->set_nombre_para_mostrar('Supra Profesor');

    $profesor->set_id('profesor');
    $profesor->set_nombre_para_mostrar('Profesor');

    $roles = array($supra_apoyo_de_alumno, $apoyo_de_alumno, $supra_coordinador, $coordinador, $supra_profesor, $profesor, $preinscripto, );

    foreach ($roles as $objeto) {
        $objeto->agregar_rol();
    }

    activar_habilidades($roles);

    activacion_registro_nuevo_usuario();
}

function activar_habilidades($roles)
{
    array_push($roles, 'administrator');

    $total = array(
        new TipoDePost('carreras'),
        new TipoDePost('documentacion'),
        new TipoDePost('tipos_de_carrera'),
        new TipoDePost('materias'),
        new TipoDePost('planes_y_programas'),
    );

    foreach ($roles as $rol) {
        $rol_obtenido = get_role(is_a($rol, 'TipoDeRol') ? $rol->get_id() : $rol);
        switch ($rol_obtenido->name) {
            case 'administrator':
                foreach ($total as $individual) {
                    foreach ($individual->get_habilidades() as $valor) {
                        $rol_obtenido->add_cap($valor);
                    }
                }
                break;

            case 'supra_apoyo_de_alumno':

                break;

            case 'apoyo_de_alumno':

                break;

            case 'supra_coordinador':

                break;

            case 'coordinador':

                break;

            case 'preinscripto':

                break;

            case 'supra_profesor':

                break;

            case 'profesor':

                break;
        }
    }
}

function activacion_registro_nuevo_usuario()
{
    // 1. Permitir que cualquiera se registre
    update_option('users_can_register', 1);

    // 2. Establecer rol por defecto (elige uno: subscriber, contributor, author)
    update_option('default_role', 'preinscripto');
}