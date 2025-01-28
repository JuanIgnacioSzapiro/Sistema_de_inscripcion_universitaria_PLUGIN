<?php
require_once dirname(__FILE__) . '/admin/post_type/post_type_carreras.php';
require_once dirname(__FILE__) . '/admin/post_type/post_type_coordinadores.php';
require_once dirname(__FILE__) . '/admin/post_type/post_type_preinscriptos.php';
require_once dirname(__FILE__) . '/admin/post_type/post_type_profesores.php';
require_once dirname(__FILE__) . '/admin/post_type/post_type_apoyo_de_alumnos.php';

function desinstalar_plugin()
{
    $apoyo_de_alumnos = new apoyo_de_alumnos();
    $carreras = new carrera();
    $coordinadores = new coordinador();
    $preinscriptos = new preinscripto();
    $profesores = new profesor();

    $apoyo_de_alumnos->deregistrar_post_type();
    $apoyo_de_alumnos->borrar_todos_los_post();
    $carreras->deregistrar_post_type();
    $carreras->borrar_todos_los_post();
    $coordinadores->deregistrar_post_type();
    $coordinadores->borrar_todos_los_post();
    $preinscriptos->deregistrar_post_type();
    $preinscriptos->borrar_todos_los_post();
    $profesores->deregistrar_post_type();
    $profesores->borrar_todos_los_post();

    flush_rewrite_rules(); // limpia permalinks

    // global $wpdb;
    // eliminar_tablas($wpdb);
}

// function eliminar_tablas($wpdb)
// {
//     $tablas = TOTALIDAD_TABLAS;

//     foreach ($tablas as $tabla) {
//         eliminar_tabla($wpdb, $tabla);
//     }
// }

// function eliminar_tabla($wpdb, $nombre_tabla)
// {
//     $nombre_tabla_completo = $wpdb->prefix . asociar(obtener_datos_default(PREFIJO_TABLA . $nombre_tabla . SUFIJO_CSV))[NOMBRE_DE_TABLA];
//     $sql = "DROP TABLE IF EXISTS $nombre_tabla_completo";
//     $wpdb->query($sql);
// }
