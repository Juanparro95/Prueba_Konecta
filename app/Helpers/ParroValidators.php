<?php

/**
 * !Función para validar los campos obligatorios y la seguridad CSRF.
 *
 * @param [type] $dataInformation
 * @return void true or false
 */
function validateCsrf($dataInformation)
{
    if (!Csrf::validate($_POST['csrf']) || !Funciones::check_posted_data($dataInformation, $_POST)) {
        return false;
    }

    return true;
}
