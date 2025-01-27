<?php
require_once(dirname(__FILE__) . "/generador_post_type.php");

class carreras extends tipo_de_post
{
    public function __construct()
    {
        $this->set_id('carreras');

        $this->set_caracteristicas(array(
            'public' => true,
            'label' => 'Carreras',
            'menu_icon' => 'dashicons-database',
        ));

        add_action('init', array($this, 'registrar_post_type'));
    }
}