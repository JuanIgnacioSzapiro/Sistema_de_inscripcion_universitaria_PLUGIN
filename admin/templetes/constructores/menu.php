<?php
if (!class_exists('Menu')) {
    class Menu
    {
        /**
         * @param mixed $array_de_items debe ser un array asociado con el indice propio del item y la accion pertinente
         * Ejemplo: [[Inicio de sesion] -> 'mostrar_popUp(template_inicio_sesion)'; [UTN - INSPT] -> 'hipervinculo']
         */
        public function __construct()
        {

        }

        function construir_menu($array_asociado_de_items)
        {
            ?>
            <menu>
                <?php
                foreach ($array_asociado_de_items as $key => $value) {
                    ?>
                    <li onclick="<?php echo $value ?>">
                        <?php echo $key ?>
                    </li>
                    <?php
                }
                ?>
            </menu>
            <?php
        }
    }
}