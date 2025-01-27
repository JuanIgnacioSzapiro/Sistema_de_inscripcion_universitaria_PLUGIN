<?php
require_once dirname(__FILE__) . '/admin/post_type/carreras.php';

function activar_plugin()
{
    $carreras = new carreras();

    flush_rewrite_rules(); // limpia permalinks
}