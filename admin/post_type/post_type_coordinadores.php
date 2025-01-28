<?php
require_once(dirname(__FILE__) . "/generador_post_type.php");

class coordinador extends tipo_de_post
{
    public function __construct()
    {
        $this->set_id('coordinadores');

        $this->set_caracteristicas(array(
            'public' => true,
            'label' => 'Coordinadores',
            'menu_icon' => 'dashicons-networking
',
            'menu_position' => 103,
        ));

        add_action('init', array($this, 'registrar_post_type'));
    }
}