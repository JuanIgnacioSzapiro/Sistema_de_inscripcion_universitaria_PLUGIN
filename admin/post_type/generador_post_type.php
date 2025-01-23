<?php

function registrar_post_type($nombre, $argumentos)
{
    register_post_type($nombre, $argumentos);
    flush_rewrite_rules(); // limpia permalinks
}

function deregistrar_post_type($nombre)
{
    unregister_post_type($nombre);
    flush_rewrite_rules(); // limpia permalinks
}