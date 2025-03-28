<?php
require_once dirname(__FILE__) . '/meta-box/generador_meta_box.php';
require_once dirname(__FILE__) . '/meta-box/meta_box_tipo_archivo.php';
require_once dirname(__FILE__) . '/meta-box/meta_box_tipo_drop_down_post.php';
require_once dirname(__FILE__) . '/meta-box/meta_box_tipo_texto.php';
require_once dirname(__FILE__) . '/filtros/creador_filtros.php';
require_once dirname(__FILE__) . '/filtros/filtro.php';
require_once dirname(__FILE__) . '/generador_post_type.php';
require_once dirname(__FILE__) . '/meta-box/meta_box_clave.php';


class CuerpoPostType extends CaracteristicasBasicasPostType
{
    private $prefijo;
    private $para_armar_columnas;

    public function __construct(
        $singular,
        $nombre_para_mostrar,
        $plural,
        $femenino,
        $prefijo,
        $icono,
        $meta,
        $para_armar_columnas,
    ) {
        $this->set_singular($singular);
        $this->set_nombre_para_mostrar($nombre_para_mostrar);
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

        // Dentro de __construct():
        add_action('admin_init', array($this, 'generar_csv'));
        add_filter('views_edit-' . $this->get_plural(), array($this, 'agregar_boton_csv'));

        add_shortcode('shortcode_listado_post_type_' . $this->get_plural(), array($this, 'mostrar_pantalla_de_listado'));

        $this->generador_pagina_post_type_listado();
    }
    public function set_prefijo($valor)
    {
        $this->prefijo = $valor;
    }

    public function get_prefijo()
    {
        return $this->prefijo;
    }

    public function set_para_armar_columnas($valor)
    {
        $this->para_armar_columnas = $valor;
    }

    public function get_para_armar_columnas()
    {
        return $this->para_armar_columnas;
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
        $nombres_post_types = get_post_types([], 'names');
        if (!empty($this->get_para_armar_columnas())) {
            foreach ($this->get_para_armar_columnas() as $columna_para_armar) {
                $post_meta = get_post_meta($post_id, $this->get_prefijo() . '_' . $this->get_plural() . '_' . $columna_para_armar, true);
                if ($columnas == $columna_para_armar) {
                    if (in_array($columna_para_armar, $nombres_post_types)) {
                        $debug = get_post($post_meta)->post_title;
                    } else {
                        $debug = $post_meta;
                    }

                    echo esc_html($debug);
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

    public function generar_csv()
    {
        $post_types = get_post_types([], 'names');

        if (!isset($_GET['download_csv']) || $_GET['download_csv'] != 1)
            return;
        if (!isset($_GET['post_type']) || $_GET['post_type'] != $this->get_plural())
            return;
        if (!wp_verify_nonce($_GET['nonce'], 'descargar_csv_' . $this->get_plural()))
            wp_die('Acceso no autorizado');

        $post_status = isset($_GET['post_status']) ? $_GET['post_status'] : 'all';
        $args = [
            'post_type' => $this->get_plural(),
            'post_status' => ($post_status === 'all') ? 'any' : $post_status,
            'posts_per_page' => -1,
        ];

        if ($post_status === 'trash')
            $args['post_status'] = 'trash';

        $posts = get_posts($args);
        $meta_box = $this->get_meta();
        $meta_fields = [];

        foreach ($meta_box->get_contenido() as $campo) {
            $meta_key = $this->get_prefijo() . '_' . $this->get_plural() . '_' . $campo->get_nombre_meta();
            $meta_fields[$meta_key] = $campo->get_etiqueta();
        }

        $meta_fields['creador'] = 'Creador';
        $meta_fields['fecha_de_carga'] = 'Fecha de carga';
        $meta_fields['modificador'] = 'Último modificador';
        $meta_fields['fecha_de_modificacion'] = 'Fecha de modificación';
        $meta_fields['estado_de_publicacion'] = 'Estado de publicación';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $this->get_plural() . '_' . $post_status . '.csv');
        $output = fopen('php://output', 'w');

        fputcsv($output, array_values($meta_fields));

        foreach ($posts as $post) {
            $row = [];
            foreach ($meta_fields as $key => $label) {
                $valor = get_post_meta($post->ID, $key, true);
                if (in_array($key, ['creador', 'fecha_de_carga', 'modificador', 'fecha_de_modificacion', 'estado_de_publicacion'])) {
                    switch ($key) {
                        case 'creador':
                            $row[] = get_the_author_meta('display_name', $post->post_author);
                            break;
                        case 'fecha_de_carga':
                            $row[] = get_the_date('', $post->ID);
                            break;
                        case 'modificador':
                            $last_id = get_post_meta($post->ID, '_edit_last', true);
                            $user = $last_id ? get_userdata($last_id)->display_name : 'N/A';
                            $row[] = $user;
                            break;
                        case 'fecha_de_modificacion':
                            $row[] = get_the_modified_date('', $post->ID);
                            break;
                        case 'estado_de_publicacion':
                            $estado = get_post_status($post->ID);
                            $row[] = $estado === 'publish' ? 'Publicado' : ucfirst($estado);
                            break;
                    }
                } elseif (is_numeric($valor) && get_post($valor) && get_post($valor)->post_type === 'attachment') {
                    $row[] = get_post(($valor))->guid;
                } elseif (in_array(str_replace($this->get_prefijo() . '_' . $this->get_plural() . '_', '', $key), $post_types)) {
                    $row[] = get_post(($valor))->post_title;
                } else {
                    $row[] = is_array($valor) ? implode('; ', $valor) : $valor;
                }
            }
            fputcsv($output, $row);
        }

        fclose($output);
        exit;
    }

    public function agregar_boton_csv($views)
    {
        $url = add_query_arg([
            'post_type' => $this->get_plural(),
            'download_csv' => 1,
            'nonce' => wp_create_nonce('descargar_csv_' . $this->get_plural())
        ], admin_url('edit.php'));

        $views['download_csv'] = '<a href="' . esc_url($url) . '" class="button">Descargar CSV</a>';
        return $views;
    }
    public function mostrar_pantalla_de_listado()
    {
        ob_start();
        if (is_user_logged_in()) {
            obtener_navbar();
        } else {
            controlar_acceso_pagina_con_shortcode();
        }
        return ob_get_clean();
    }

    public function generador_pagina_post_type_listado()
    {
        $titulo = 'Listado de ' . $this->get_nombre_para_mostrar();
        $paginador = new Paginador($titulo, '[shortcode_listado_post_type_' . $this->get_plural() . ']');
        $objPage = $paginador->new_get_page_by_title($titulo);
        if (empty($objPage)) {
            $paginador->create_page($titulo, '[shortcode_listado_post_type_' . $this->get_plural() . ']');
        }
    }
}