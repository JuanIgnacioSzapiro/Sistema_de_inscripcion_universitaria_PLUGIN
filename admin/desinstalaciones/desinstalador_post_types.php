<?php
require_once dirname(__FILE__) . '/../post_type/generador_post_type.php';

function desinstalar_post_types()
{
    $post = array();

    if (!empty($post)) {
        foreach (array($post) as $objeto) {
            $objeto->deregistrar_post_type();
            $objeto->borrar_todos_los_post();
        }
    }
}