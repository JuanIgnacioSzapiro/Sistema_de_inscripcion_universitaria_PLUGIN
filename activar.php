<?php
require_once dirname(__FILE__) . '/admin/activaciones/activador_post_types.php';
require_once dirname(__FILE__) . '/admin/activaciones/activador_roles.php';

function activar_plugin()
{
    activar_post_types();

    activar_roles();

    flush_rewrite_rules(); // limpia permalinks
}