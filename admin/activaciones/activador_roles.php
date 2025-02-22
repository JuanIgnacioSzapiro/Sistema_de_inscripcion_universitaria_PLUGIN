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

    $total = array(
        new TipoDePost('carreras'),
        new TipoDePost('tipos_de_carrera'),
        new TipoDePost('materias'),
        new TipoDePost('planes_y_programas'),
        new TipoDePost('tests'),
    );

    foreach ($roles as $rol) {
        $rol_obtenido = get_role(is_a($rol, 'TipoDeRol') ? $rol->get_id() : $rol);
        switch ($rol_obtenido->name) {
            case 'administrator':
                foreach($total as $individual){
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