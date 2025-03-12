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

    $rol_obtenido = get_role('administrator');

    $total = array(
        // new TipoDePost('carreras'),
        // new TipoDePost('tipos_de_carrera'),
        // new TipoDePost('materias'),       
        // new TipoDePost('planes_y_programas'), 
        // new TipoDePost('documentacion'), 
    );
    foreach($total as $individual){
        foreach ($individual->get_habilidades() as $valor) {
            $rol_obtenido->remove_cap($valor);
        }
    }
}
