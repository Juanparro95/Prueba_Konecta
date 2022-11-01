<?php

namespace ParroFramework\Helpers;

/**
 *  ! Clase Helpers, contiene constantes iniciales del sistema para que funcione correctamente.
 */

class Helper
{

    // Constante conexión a la base de datos
    public static function connection()
    {
        return [
            "engine" => $_ENV['DB_CONNECTION'],
            "host" => $_ENV['DB_HOST'],
            "port" => $_ENV['DB_PORT'],
            "database" => $_ENV['DB_DATABASE'],
            "username" => $_ENV['DB_USERNAME'],
            "password" => $_ENV['DB_PASSWORD'],
            "charset"  => $_ENV['DB_CHARSET']
        ];
    }
}
