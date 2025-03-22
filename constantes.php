<?php

function cargar_configuracion_desde_csv()
{
    // Ruta al archivo CSV en el directorio del plugin
    $csv_file = plugin_dir_path(__FILE__) . 'constantes.csv';

    // Verificar si el archivo existe
    if (!file_exists($csv_file)) {
        error_log('El archivo de configuración CSV no existe');
        return;
    }

    // Verificar que sea un archivo CSV válido
    $file_info = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($file_info, $csv_file);
    finfo_close($file_info);

    if (!in_array($mime_type, ['text/plain', 'text/csv'])) {
        error_log('El archivo no es un CSV válido');
        return;
    }

    // Abrir y leer el archivo CSV
    if (($handle = fopen($csv_file, 'r')) !== FALSE) {
        // Leer encabezados
        $headers = fgetcsv($handle, 1000, ',');

        // Leer primera línea de datos
        $data = fgetcsv($handle, 1000, ',');

        fclose($handle);

        if ($data !== FALSE) {
            // Combinar encabezados con datos
            $config = array_combine($headers, $data);

            // Sanitizar y asignar a variables globales
            foreach ($config as $key => $value) {
                $global_var_name = sanitize_key($key);
                $global_value = sanitize_text_field($value);

                // Crear variables globales dinámicamente
                $GLOBALS[$global_var_name] = $global_value;

                // Opcional: También definir como constante
                // if (!defined(strtoupper($global_var_name))) {
                //     define(strtoupper($global_var_name), $global_value);
                // }
            }
        }
    }
}
