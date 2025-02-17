<?php

class Sanitizar{
    // Limpia la entrada del usuario (previene XSS e Inyección SQL)
    public static function limpiar($conexion, $input) {
        $input = trim($input); // Elimina espacios en blanco
        $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8'); // Escapa caracteres especiales
        return mysqli_real_escape_string($conexion, $input); // Escapa para SQL
    }

    // Limpia sin conexión (cuando no necesitas SQL)
    public static function limpiarTexto($input) {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
}

?>