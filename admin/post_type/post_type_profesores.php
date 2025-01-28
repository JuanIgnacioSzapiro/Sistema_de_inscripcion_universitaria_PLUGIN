<?php
require_once(dirname(__FILE__) . "/generador_post_type.php");

class profesor extends tipo_de_post
{
    public function __construct()
    {
        $this->set_id('profesores');

        $this->set_caracteristicas(array(
            'public' => true,
            'label' => 'Profesores',
            'menu_icon' => 'dashicons-welcome-learn-more',
            'menu_position' => 105,
        ));

        add_action('init', array($this, 'registrar_post_type'));
    }
}