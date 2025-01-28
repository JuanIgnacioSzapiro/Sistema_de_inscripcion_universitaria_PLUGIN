<?php
require_once(dirname(__FILE__) . "/generador_post_type.php");

class carrera extends tipo_de_post
{
    public function __construct()
    {
        $this->set_id('carreras');

        $this->set_caracteristicas(array(
            'public' => true,
            'label' => 'Carreras',
            'menu_icon' => 'dashicons-admin-multisite',
            'menu_position' => 102,
        ));

        add_action('init', array($this, 'registrar_post_type'));
    }
}