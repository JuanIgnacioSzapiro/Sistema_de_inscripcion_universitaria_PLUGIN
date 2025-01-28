<?php

class tipo_de_rol
{
    protected $id;
    protected $nombre_para_mostrar;
    protected $habilidades;

    public function __construct()
    {
    }

    public function get_id()
    {
        return $this->id;
    }
    public function get_nombre_para_mostrar()
    {
        return $this->nombre_para_mostrar;
    }
    public function get_habilidades()
    {
        return $this->habilidades;
    }
    protected function set_id($valor)
    {
        $this->id = $valor;
    }
    protected function set_nombre_para_mostrar($valor)
    {
        $this->nombre_para_mostrar = $valor;
    }
    protected function set_habilidades($valor)
    {
        $this->habilidades = $valor;
    }
}