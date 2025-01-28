<?php
require_once dirname(__FILE__) . '/admin/post_type/post_type_carreras.php';
require_once dirname(__FILE__) . '/admin/post_type/post_type_coordinadores.php';
require_once dirname(__FILE__) . '/admin/post_type/post_type_preinscriptos.php';
require_once dirname(__FILE__) . '/admin/post_type/post_type_profesores.php';
require_once dirname(__FILE__) . '/admin/post_type/post_type_apoyo_de_alumnos.php';

function desactivar_plugin()
{
    $apoyo_de_alumnos = new apoyo_de_alumnos();
    $carreras = new carrera();
    $coordinadores = new coordinador();
    $preinscriptos = new preinscripto();
    $profesores = new profesor();

    $apoyo_de_alumnos->deregistrar_post_type();
    $carreras->deregistrar_post_type();
    $coordinadores->deregistrar_post_type();
    $preinscriptos->deregistrar_post_type();
    $profesores->deregistrar_post_type();

    flush_rewrite_rules(); // limpia permalinks

    //global $wpdb;
    //vaciar_tablas($wpdb);
}

// function vaciar_tablas($wpdb)
// {
//     $tablas = TOTALIDAD_TABLAS;

//     foreach ($tablas as $tabla) {
//         vaciar_tabla($wpdb, $tabla);
//     }
// }

// function vaciar_tabla($wpdb, $nombre_tabla)
// {
//     $nombre_tabla_completo = $wpdb->prefix . asociar(obtener_datos_default(PREFIJO_TABLA . $nombre_tabla . SUFIJO_CSV))[NOMBRE_DE_TABLA];
//     $sql = "TRUNCATE TABLE $nombre_tabla_completo";
//     $wpdb->query($sql);
// }