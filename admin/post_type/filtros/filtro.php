<?php //filtro.php
require_once dirname(__FILE__) . '/creador_filtros.php';

class Filtro extends CreadorFiltros{
    public function __construct($id_filtro, $query, $ids, $texto)
    {
        $this->set_id_filtro($id_filtro);
        $this->set_query($query);
        $this->set_ids($ids);
        $this->set_texto($texto);
    }
}
