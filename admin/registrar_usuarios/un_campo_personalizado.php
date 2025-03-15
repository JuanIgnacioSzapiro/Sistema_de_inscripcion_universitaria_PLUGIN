<?php
require_once dirname(__FILE__) . '/generar_campo_registro.php';
class CampoIndividual
{
    private $id_campo;
    private $texto_para_mostrar;
    private $puede_repetirse;
    private $tipo_de_input;
    private $primera_debe_ser_mayuscula;

    public function __construct($id_campo, $texto_para_mostrar, $puede_repetirse = true, $tipo_de_input = 'string', $primera_debe_ser_mayuscula = true)
    {
        $this->set_id_campo(sanitize_key($id_campo));
        $this->set_texto_para_mostrar(esc_html($texto_para_mostrar));
        $this->set_puede_repetirse(esc_html($puede_repetirse));
        $this->set_tipo_de_input(esc_html($tipo_de_input));
        $this->set_primera_debe_ser_mayuscula(esc_html($primera_debe_ser_mayuscula));
    }

    public function get_id_campo()
    {
        return $this->id_campo;
    }
    public function get_texto_para_mostrar()
    {
        return $this->texto_para_mostrar;
    }
    public function set_id_campo($valor)
    {
        $this->id_campo = $valor;
    }
    public function set_texto_para_mostrar($valor)
    {
        $this->texto_para_mostrar = $valor;
    }
    public function get_puede_repetirse()
    {
        return $this->puede_repetirse;
    }
    public function set_puede_repetirse($valor)
    {
        $this->puede_repetirse = $valor;
    }
    public function get_tipo_de_input()
    {
        return $this->tipo_de_input;
    }
    public function set_tipo_de_input($valor)
    {
        $this->tipo_de_input = $valor;
    }
    public function get_primera_debe_ser_mayuscula()
    {
        return $this->primera_debe_ser_mayuscula;
    }
    public function set_primera_debe_ser_mayuscula($valor)
    {
        $this->primera_debe_ser_mayuscula = $valor;
    }
}