<?php
require_once dirname(__FILE__) . '/admin/activaciones/activador_post_types.php';
require_once dirname(__FILE__) . '/admin/activaciones/activador_roles.php';
require_once dirname(__FILE__) . '/admin/activaciones/activador_paginas.php';
require_once dirname(__FILE__) . '/admin/activaciones/activar_campo_registrar_usuario.php';


function activar_plugin()
{
    activar_post_types();

    activar_roles();

    activar_paginas();

    activar_campo_registrar_usuario();

    include_once dirname(__FILE__) . '/admin/shortcodes/galería.php';

    include_once dirname(__FILE__) . '/admin/shortcodes/documentacion_inscripcion_a_carreras_2025.php';

    flush_rewrite_rules(); // limpia permalinks
}