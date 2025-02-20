<?php

class Sanitizar{
    // Limpia la entrada del usuario (previene XSS e Inyección SQL)
    public static function limpiar($input) {
        $input = trim($input); // Elimina espacios en blanco
        $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
        return $input; // Escapa caracteres especiales
    }
}

?>