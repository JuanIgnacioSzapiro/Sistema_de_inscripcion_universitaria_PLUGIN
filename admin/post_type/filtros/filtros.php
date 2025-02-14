<?php //filtros.php
class Filtros
{
    protected $post_type_padre;
    protected $id_filtro;
    protected $query;
    protected $ids;
    protected $texto;


    public function __construct($post_type_padre, $id_filtro, $query, $ids, $texto)
    {
        $this->set_post_type_padre($post_type_padre);
        $this->set_id_filtro($id_filtro);
        $this->set_query($query);
        $this->set_ids($ids);
        $this->set_texto($texto);


        add_action('restrict_manage_posts', array($this, 'borrar_filtros'));

        add_action('restrict_manage_posts', array($this, 'agregar_filtro'));

        add_action('pre_get_posts', array($this, 'manejar_filtro'));


        // Eliminar buscador nativo del listado
        add_action('admin_head-edit.php', function () {
            global $typenow;

            if ($this->get_post_type_padre() === $typenow) {
                ?>
                <style>
                    .search-box {
                        display: none !important;
                    }
                </style>
                <?php
            }
        });
    }

    public function get_post_type_padre()
    {
        return $this->post_type_padre;
    }
    public function get_id_filtro()
    {
        return $this->id_filtro;
    }
    public function get_query()
    {
        return $this->query;
    }
    public function get_ids()
    {
        return $this->ids;
    }
    public function get_texto()
    {
        return $this->texto;
    }
    public function set_post_type_padre($valor)
    {
        $this->post_type_padre = $valor;
    }
    public function set_id_filtro($valor)
    {
        $this->id_filtro = $valor;
    }
    public function set_query($valor)
    {
        $this->query = $valor;
    }
    public function set_ids($valor)
    {
        $this->ids = $valor;
    }
    public function set_texto($valor)
    {
        $this->texto = $valor;
    }

    public function borrar_filtros($post_type)
    {
        if ($this->get_post_type_padre() !== $post_type) {
            return;
        }

        ?>
        <div class="alignright">
            <button class="button action" onclick="borrar_filtros()">Borrar filtros</button>
        </div>
        <script>
            function borrar_filtros() {
                document.getElementById("<?php echo $this->get_id_filtro(); ?>").value = "";
            }
        </script>
        <?php
    }

    public function agregar_filtro($post_type)
    {
        if ($this->get_post_type_padre() !== $post_type) {
            return;
        }

        $current_value = isset($_GET[$this->get_id_filtro()]) ? sanitize_text_field($_GET[$this->get_id_filtro()]) : '';
        ?>
        <div class="alignright">
            <label for="<?php echo $this->get_id_filtro(); ?>">
                <?php echo esc_html($this->get_texto()); ?>
            </label>
            <input type="text" 
                   id="<?php echo $this->get_id_filtro(); ?>" 
                   name="<?php echo $this->get_id_filtro(); ?>"
                   value="<?php echo esc_attr($current_value); ?>">
        </div>
        <?php
    }

    public function manejar_filtro($query)
    {
        global $pagenow, $wpdb;

        if (!is_admin() || $pagenow !== 'edit.php' || !$query->is_main_query() || $this->get_post_type_padre() !== $query->get('post_type')) {
            return;
        }

        if (!empty($_GET[$this->get_id_filtro()])) {
            $search_term = sanitize_text_field($_GET[$this->get_id_filtro()]);
            $sql_query = $this->get_query();

            $num_placeholders = substr_count($sql_query, '%s');
            $like_term = '%' . $wpdb->esc_like($search_term) . '%';
            $args = array_fill(0, $num_placeholders, $like_term);

            // Preparar consulta de forma segura
            $sql = $wpdb->prepare($sql_query, ...$args);
            
            $ids = $wpdb->get_col($sql);

            if (!empty($ids)) {
                $query->set($this->get_ids(), $ids);
            } else {
                $query->set('post__in', array(0));
            }
        }
    }
}
