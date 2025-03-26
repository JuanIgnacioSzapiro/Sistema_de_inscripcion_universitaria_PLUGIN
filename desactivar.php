<?php
require_once dirname(__FILE__) . '/admin/desactivaciones/desactivador_post_types.php';
require_once dirname(__FILE__) . '/admin/desinstalaciones/desinstalador_roles.php';
function desactivar_plugin()
{
    desactivar_post_types();

    desinstalar_roles();

    flush_rewrite_rules(); // limpia permalinks
}