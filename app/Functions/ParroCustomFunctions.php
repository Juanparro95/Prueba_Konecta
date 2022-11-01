<?php

namespace ParroFramework\Functions;

class Custom
{
    /**
     * Retorna el rol del usuario registrado
     *
     * @return void
     */
    public static function getUserRole()
    {
        return $rol = Funciones::getUser('rol');
    }

    /**
     * Roles principales por defecto
     *
     * @return void
     */
    public static function getDefaultRoles()
    {
        return ['root', 'admin'];
    }


    /**
     * Roles aceptados en el controlador
     *
     * @param [type] $rol
     * @param [type] $roles_aceptados
     * @return boolean
     */
    public static function isUser($rol, $roles_aceptados)
    {
        $default = self::getDefaultRoles();

        if (!is_array($roles_aceptados)) {
            array_push($default, $roles_aceptados);
            return in_array($rol, $default);
        }

        return in_array($rol, array_merge($default, $roles_aceptados));
    }
}
