<?php
require_once dirname(__FILE__) . '/meta-box/generador_meta_box.php';
require_once dirname(__FILE__) . '/meta-box/meta_box_tipo_archivo.php';
require_once dirname(__FILE__) . '/meta-box/meta_box_tipo_drop_down_post.php';
require_once dirname(__FILE__) . '/meta-box/meta_box_tipo_texto.php';
require_once dirname(__FILE__) . '/filtros/creador_filtros.php';
require_once dirname(__FILE__) . '/filtros/filtro.php';
require_once dirname(__FILE__) . '/generador_post_type.php';

class CreadorTipoDePost extends TipoDePost
{
    public function __construct(
        $singular,
        $plural,
        $femenino,
        $prefijo,
        $icono,
        $meta,
        $para_armar_columnas,
    ) {
        $this->set_singular($singular);
        $this->set_plural($plural);
        $this->set_femenino($femenino);
        $this->set_prefijo($prefijo);
        $this->set_icono($icono);
        $this->set_meta($meta);
        $this->set_para_armar_columnas($para_armar_columnas);

        $meta = $this->get_meta();
        $meta->set_post_type_de_origen($this->get_plural());

        $meta->crear_tipo_meta_box();

        // Register sortable columns
        add_filter('manage_edit-' . $this->get_plural() . '_sortable_columns', array($this, 'mis_columnas_ordenables'));
        // Handle custom sorting
        add_action('pre_get_posts', array($this, 'manejar_ordenamiento_columnas'));
        add_filter('manage_' . $this->get_plural() . '_posts_columns', array($this, 'mis_columnas'));
        add_action('manage_' . $this->get_plural() . '_posts_custom_column', array($this, 'cargar_mis_columnas'), 10, 2);

        $this->mis_filtros();

        add_action('template_redirect', array($this, 'add_template_support'));

        $this->registrar_post_type();
    }
    public function mis_columnas_ordenables($columns)
    {
        if (!empty($this->get_para_armar_columnas())) {
            foreach ($this->get_para_armar_columnas() as $columna_para_armar) {
                $columns[$columna_para_armar] = $this->get_prefijo() . '_' . $this->get_plural() . '_' . $columna_para_armar;
            }
        }
        $columns['creador'] = 'author';
        $columns['fecha_de_carga'] = 'date';
        $columns['modificador'] = 'Último modificador';
        $columns['fecha_de_modificacion'] = 'modified';
        $columns['estado_de_publicacion'] = 'post_status';
        return $columns;
    }


    public function manejar_ordenamiento_columnas($query)
    {
        global $wpdb;

        $orderby = $query->get('orderby');

        if (!empty($this->get_para_armar_columnas())) {
            foreach ($this->get_para_armar_columnas() as $columna_para_armar) {
                if ($orderby == $this->get_prefijo() . '_' . $this->get_plural() . '_' . $columna_para_armar) {
                    // Obtener el valor del meta_key para determinar si es numérico o no
                    $meta_key = $this->get_prefijo() . '_' . $this->get_plural() . '_' . $columna_para_armar;
                    $meta_value = $wpdb->get_var($wpdb->prepare(
                        "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = %s LIMIT 1",
                        $meta_key
                    ));

                    // Determinar si el valor es numérico
                    if (is_numeric($meta_value)) {
                        $query->set('meta_key', $meta_key);
                        $query->set('orderby', 'meta_value_num'); // Ordenar numéricamente
                    } else {
                        $query->set('meta_key', $meta_key);
                        $query->set('orderby', 'meta_value'); // Ordenar alfabéticamente
                    }
                }
            }
        } elseif ($orderby == 'modificador') {
            $query->get_results($query->prepare("SELECT * FROM wp_postmeta ORDER BY meta_id"));
        } elseif ($orderby == 'estado_de_publicacion') {
            $query->set('orderby', 'post_status');

        }
    }

    public function mis_columnas($columnas)
    {
        $contador = 1;
        $nuevas_columnas = array(
            'cb' => $columnas['cb'],
            'creador' => 'Creador',
            'fecha_de_carga' => 'Fecha de carga',
            'modificador' => 'Último modificador',
            'fecha_de_modificacion' => 'Fecha de modificación',
            'estado_de_publicacion' => 'Estado de publicación',
        );

        if (!empty($this->get_para_armar_columnas())) {
            foreach ($this->get_para_armar_columnas() as $columnas_para_armar) {
                $nuevas_columnas = array_merge(
                    array('cb' => $nuevas_columnas['cb']),
                    array_slice($nuevas_columnas, 0, $contador, true),
                    array($columnas_para_armar => str_replace('_', ' ', ucfirst($columnas_para_armar))),
                    array_slice($nuevas_columnas, $contador, null, true)
                );
                $contador += 1;
            }
        } else {
            // Agregar la columna 'title' después de 'cb'
            $nuevas_columnas = array_merge(
                array('cb' => $nuevas_columnas['cb'], 'title' => 'Título'),
                array_slice($nuevas_columnas, 1, null, true)
            );
        }

        return $nuevas_columnas;
    }


    public function cargar_mis_columnas($columnas, $post_id)
    {
        if (!empty($this->get_para_armar_columnas())) {
            foreach ($this->get_para_armar_columnas() as $columna_para_armar) {
                if ($columnas == $columna_para_armar) {
                    echo esc_html(get_post_meta($post_id, $this->get_prefijo() . '_' . $this->get_plural() . '_' . $columna_para_armar, true));
                }
            }
        }
        if ($columnas == 'creador') {
            echo esc_html(get_the_author());
        } elseif ($columnas == 'fecha_de_carga') {
            echo esc_html(get_the_date("", $post_id));
        } elseif ($columnas == 'modificador') {
            $last_id = get_post_meta($post_id, '_edit_last', true);
            if ($last_id) {
                $user = get_userdata($last_id);
                echo esc_html($user->display_name);
            } else {
                echo esc_html__('N/A', 'textdomain');
            }
        } elseif ($columnas == 'fecha_de_modificacion') {
            echo esc_html(get_the_modified_date("", $post_id));
        } elseif ($columnas == 'estado_de_publicacion') {
            $estado = get_post_status($post_id);
            $estados = array(
                'publish' => __('Publicado', 'text-domain'),
                'draft' => __('Borrador', 'text-domain'),
                'pending' => __('Pendiente de revisión', 'text-domain'),
                'future' => __('Programado', 'text-domain'),
                'private' => __('Privado', 'text-domain')
            );
            echo esc_html($estados[$estado] ?? ucfirst($estado));
        }
    }

    public function mis_filtros()
    {
        $id_filtro = '';
        $la_query = '';
        $post_type = $this->get_plural();

        if (!empty($this->get_para_armar_columnas())) {
            foreach ($this->get_para_armar_columnas() as $key => $columna_para_armar) {
                $id_filtro .= '_' . $columna_para_armar;
                if ($key < count($this->get_para_armar_columnas()) - 1) {
                    $id_filtro .= '_o_';
                }

                $meta_key = $this->get_prefijo() . '_' . $this->get_plural() . '_' . $columna_para_armar;
                $la_query .= "(wp_postmeta.meta_key = '$meta_key' AND wp_postmeta.meta_value LIKE %s AND wp_posts.post_type = '$post_type')";
                if ($key < count($this->get_para_armar_columnas()) - 1) {
                    $la_query .= ' OR ';
                }
            }

            $filtrosXcreador = new CreadorFiltros($post_type, array(
                new Filtro(
                    'filtroXcreador',
                    "SELECT ID FROM wp_posts WHERE post_author IN (SELECT ID FROM wp_users WHERE user_login LIKE %s) AND post_type = '$post_type'",
                    'post__in',
                    'Filtrar por creador'
                ),
                new Filtro(
                    'filtrar_x' . $id_filtro,
                    "SELECT DISTINCT wp_postmeta.post_id FROM wp_postmeta INNER JOIN wp_posts ON wp_postmeta.post_id = wp_posts.ID WHERE ($la_query)",
                    'post__in',
                    'Filtrar por ' . implode(' o ', str_replace("_", " ", $this->get_para_armar_columnas()))
                )
            ));
        } else {
            $filtrosXcreador = new CreadorFiltros($post_type, array(
                new Filtro(
                    'filtroXcreador',
                    "SELECT ID FROM wp_posts WHERE post_author IN (SELECT ID FROM wp_users WHERE user_login LIKE %s) AND post_type = '$post_type'",
                    'post__in',
                    'Filtrar por creador'
                ),
                new Filtro(
                    'buscar_x_titulo',
                    "SELECT ID FROM wp_posts WHERE post_title LIKE %s AND post_type = '$post_type'",
                    'post__in',
                    'Buscar por título'
                )
            ));
        }
    }
    public function add_template_support()
    {
        $post_type = $this->get_plural();

        add_filter("single_template", function ($template) use ($post_type) {
            global $post;
            return $post->post_type === $post_type && !locate_template("single-{$post_type}.php")
                ? dirname(__FILE__) . '/../templetes/muestra_individual.php'
                : $template;
        });
    }
}