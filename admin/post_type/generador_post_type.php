<?php
class tipo_de_post
{
    protected $id;
    protected $caracteristicas;

    public function __construct()
    {
    }

    protected function set_id($valor)
    {
        $this->id = $valor;
    }

    protected function set_caracteristicas($valor)
    {
        $this->caracteristicas = $valor;
    }

    public function get_id()
    {
        return $this->id;
    }

    public function get_caracteristicas()
    {
        return $this->caracteristicas;
    }

    public function registrar_post_type()
    {
        register_post_type($this->get_id(), $this->get_caracteristicas());
    }

    public function deregistrar_post_type()
    {
        unregister_post_type($this->get_id());
    }

    public function obtener_todos_los_post()
    {
        return get_posts(array(
            'post_type' => $this->get_id(),
            'numberposts' => -1,
            'post_status' => 'any',
        ));
    }

    public function borrar_todos_los_post()
    {
        foreach ($this->obtener_todos_los_post() as $objeto) {
            wp_delete_post($objeto->ID, true);
        }
    }

    public function hacer_backup($objetos)
    {

    }
}