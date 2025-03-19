<?php
require_once dirname(__FILE__) . '/admin/activaciones/activador_post_types.php';
require_once dirname(__FILE__) . '/admin/activaciones/activador_roles.php';
require_once dirname(__FILE__) . '/admin/activaciones/activador_paginas.php';
require_once dirname(__FILE__) . '/admin/activaciones/activar_campo_registrar_usuario.php';
require_once dirname(__FILE__) . '/admin/activaciones/activador_shortcodes.php';

function activar_plugin()
{
    include_once dirname(__FILE__) . '/constantes.php';

    activar_post_types();

    activar_roles();

    activar_paginas();

    activar_campo_registrar_usuario();

    activar_shortcodes();

    flush_rewrite_rules();
}