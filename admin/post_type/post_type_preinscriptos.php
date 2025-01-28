<?php
require_once(dirname(__FILE__) . "/generador_post_type.php");

class preinscripto extends tipo_de_post
{
    public function __construct()
    {
        $this->set_id('preinscriptos');

        $this->set_caracteristicas(array(
            'public' => true,
            'label' => 'Preinscriptos',
            'menu_icon' => 'dashicons-id-alt
',
            'menu_position' => 104,
        ));

        add_action('init', array($this, 'registrar_post_type'));
    }
}