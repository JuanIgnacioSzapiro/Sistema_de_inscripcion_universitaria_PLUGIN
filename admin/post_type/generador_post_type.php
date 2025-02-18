<?php
class TipoDePost
{
    private $singular;
    private $plural;
    private $femenino;
    private $prefijo;

    public function __construct(
        $plural,
    ) {
        $this->set_plural($plural);
    }

    public function set_singular($valor)
    {
        $this->singular = $valor;
    }

    public function get_singular()
    {
        return $this->singular;
    }

    public function set_plural($valor)
    {
        $this->plural = $valor;
    }

    public function get_plural()
    {
        return $this->plural;
    }

    public function get_singular_mayuscula()
    {
        return ucfirst($this->get_singular());
    }

    public function get_plural_mayuscula()
    {
        return ucfirst($this->get_plural());
    }
    public function set_femenino($femenino)
    {
        $this->femenino = $femenino;
    }
    public function get_femenino()
    {
        return $this->femenino;
    }

    public function get_caracteristicas()
    {
        return array(
            'public' => true,
            'show_ui' => true,
            'labels' => array(
                'name' => __($this->get_plural_mayuscula()),
                'singular_name' => __($this->get_singular_mayuscula()),
                'add_new' => __('Agregar nuev' . ($this->get_femenino() ? 'a' : 'o')),
                'add_new_item' => __('Agregar nuev' . ($this->get_femenino() ? 'a' : 'o') . ' ' . $this->get_singular()),
                'edit' => __('Editar'),
                'edit_item' => __('Editar ' . $this->get_singular()),
                'new_item' => __('Nuev' . ($this->get_femenino() ? 'a' : 'o') . ' ' . $this->get_singular()),
                'view' => __('Ver ' . $this->get_singular()),
                'view_item' => __('Ver ' . $this->get_singular()),
                'search_items' => __('Buscar'),
                'not_found' => __('No se encontraron ' . $this->get_plural()),
                'not_found_in_trash' => __('No se encontraron ' . $this->get_plural() . ' en la basura'),
                'parent' => __($this->get_plural_mayuscula()),
            ),
            'menu_icon' => 'dashicons-admin-multisite',
            'show_in_rest' => true,
            'rest_base' => $this->get_plural(),
            'has_archive' => true,
            'show_in_menu' => true,
            'supports' => false,
            'exclude_from_search' => false,
            'capability_type' => $this->get_plural(),
            'map_meta_cap' => true,
            'capabilities' => [
                'edit_post' => 'edit_' . $this->get_plural(),
                'read_post' => 'read_' . $this->get_plural(),
                'delete_post' => 'delete_' . $this->get_plural(),
                'edit_posts' => 'edit_multiples_' . $this->get_plural(),
                'edit_others_posts' => 'edit_others_multiples_' . $this->get_plural(),
                'publish_posts' => 'publish_multiples_' . $this->get_plural(),
                'read_private_posts' => 'read_private_multiples_' . $this->get_plural(),
                'delete_posts' => 'delete_multiples_' . $this->get_plural(),
                'delete_private_posts' => 'delete_private_multiples_' . $this->get_plural(),
                'delete_published_posts' => 'delete_published_multiples_' . $this->get_plural(),
                'delete_others_posts' => 'delete_others_multiples_' . $this->get_plural(),
                'edit_private_posts' => 'edit_private_multiples_' . $this->get_plural(),
                'edit_published_posts' => 'edit_published_multiples_' . $this->get_plural(),
                'create_posts' => 'create_multiples_' . $this->get_plural(),
            ],
        );
    }

    public function get_habilidades()
    {
        return [
            'edit_post' => 'edit_' . $this->get_plural(),
            'read_post' => 'read_' . $this->get_plural(),
            'delete_post' => 'delete_' . $this->get_plural(),
            'edit_posts' => 'edit_multiples_' . $this->get_plural(),
            'edit_others_posts' => 'edit_others_multiples_' . $this->get_plural(),
            'publish_posts' => 'publish_multiples_' . $this->get_plural(),
            'read_private_posts' => 'read_private_multiples_' . $this->get_plural(),
            'delete_posts' => 'delete_multiples_' . $this->get_plural(),
            'delete_private_posts' => 'delete_private_multiples_' . $this->get_plural(),
            'delete_published_posts' => 'delete_published_multiples_' . $this->get_plural(),
            'delete_others_posts' => 'delete_others_multiples_' . $this->get_plural(),
            'edit_private_posts' => 'edit_private_multiples_' . $this->get_plural(),
            'edit_published_posts' => 'edit_published_multiples_' . $this->get_plural(),
            'create_posts' => 'create_multiples_' . $this->get_plural(),
        ];
    }
    public function set_prefijo($valor)
    {
        $this->prefijo = $valor;
    }

    public function get_prefijo()
    {
        return $this->prefijo;
    }

    public function registrar_post_type()
    {
        register_post_type($this->get_plural(), $this->get_caracteristicas());
    }

    public function deregistrar_post_type()
    {
        unregister_post_type($this->get_plural());
    }

    public function obtener_todos_los_post()
    {
        return get_posts(array(
            'post_type' => $this->get_plural(),
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