<?php
require_once dirname(__FILE__) . '/admin/post_type/carreras.php';

function desinstalar_plugin()
{
    $carreras = new carreras();
    $carreras->deregistrar_post_type();
    $carreras->borrar_todos_los_post();

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
