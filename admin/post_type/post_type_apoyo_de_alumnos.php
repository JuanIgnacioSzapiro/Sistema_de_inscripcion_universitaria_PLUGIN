<?php
require_once(dirname(__FILE__) . "/generador_post_type.php");

class apoyo_de_alumnos extends tipo_de_post
{
    public function __construct()
    {
        $this->set_id('apoyo_de_alumnos');

        $this->set_caracteristicas(array(
            'public' => true,
            'label' => 'Apoyo de alumnos',
            'menu_icon' => 'dashicons-groups
',
            'menu_position' => 101,
        ));

        add_action('init', array($this, 'registrar_post_type'));
    }
}