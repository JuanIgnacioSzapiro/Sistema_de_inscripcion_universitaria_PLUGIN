<?php
require_once dirname(__FILE__) . '/admin/desinstalaciones/desinstalador_post_types.php';
require_once dirname(__FILE__) . '/admin/desinstalaciones/desinstalador_roles.php';

function desinstalar_plugin()
{
    desinstalar_post_types();

    desinstalar_roles();

    flush_rewrite_rules();
}