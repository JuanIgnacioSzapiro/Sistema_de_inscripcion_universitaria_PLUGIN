<?php
function obtener_templete_inicio_sesion()
{
    ?>
    <form id="inicio_de_sesion" method="post">
        <fieldset>
            <legend>Inicio de sesión</legend>
            <p>
                <input id="mail_o_dni" name="mail_o_dni" type="text" />
                <label for="mail_o_dni">Mail institucional o DNI</label>
            </p>
            <p>
                <input id="clave" name="clave" type="password" />
                <label for="clave">Contraseña</label>
            </p>
            <p>
                <button type="submit" name="ingresar">Ingresar</button>
                <button name="registrarse">Registrarse</button>
            </p>
        </fieldset>
    </form>
    <?php
}