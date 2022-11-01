<?php

namespace ParroFramework\Configs;

use Exception;
use ParroFramework\Functions\Funciones;

class ParroSession
{

    private $id; // identificador del usuario en curso
    private $token;

    private $parro_users_table     = KONECTA_USERS_TABLE;
    //private $parro_permissions_table  = PARRO_PERMISSIONS_TABLE;
    //private $parro_users_permissions_table  = PARRO_USERS_PERMISSIONS_TABLE;
    private $parro_cookies         = PARRO_COOKIES;
    private $parro_cookie_id       = PARRO_COOKIE_ID;
    private $parro_cookie_token    = PARRO_COOKIE_TOKEN;
    private $parro_cookie_lifetime = PARRO_COOKIE_LIFETIME;
    private $parro_cookie_path     = PARRO_COOKIE_PATH;
    private $parro_cookie_domain   = PARRO_COOKIE_DOMAIN;
    private $current_user        = null;


    function __construct()
    {
        // Validar que todo esté en orden configurado
        $this->check_if_ready();
    }

    /**
     * Verificamos que las configuraciones
     * sean correctas para poder trabajar
     * con sesiones persistentes
     *
     * @return bool
     */
    public function check_if_ready()
    {
        // Se verifica la existencia correcta de las constantes requeridas y variables
        try {
            if ($this->parro_cookies === false || !defined('PARRO_COOKIES')) {
                Funciones::parro_die(sprintf('Es requerida la constante %s para poder trabajar con sesiones persistentes de %s', 'PARRO_COOKIES', Funciones::get_parro_name()));
            }

            // Verificar que haya una conexión con la base de datos
            $tables = Model::list_tables();
            if (empty($tables)) {
                throw new Exception('No hay tablas en la base de datos.');
            }

            // Verificar que exista la tabla de usuarios en la base de datos
            if (!Model::table_exists($this->parro_users_table)) {
                throw new Exception(sprintf('No existe la tabla %s en la base de datos.', $this->parro_users_table));
            }

            // Proceder solo si todo está en orden
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Valida si existe una sesión almacenada en cookies / y si es válida
     * @access public
     * @var $_COOKIE ID_USR $_COOKIE TKN
     * @return array | false
     **/
    public static function  authenticate()
    {
        // Instancia de nuestra parroSession
        $auth = new self();

        // Validar la existencia de los cookies en el sistema
        if (!Funciones::cookie_exists($auth->parro_cookie_id) || !Funciones::cookie_exists($auth->parro_cookie_token)) {
            // Si no existe la coincidencia vamos a borrar los cookies por seguridad
            Funciones::destroy_cookie($auth->parro_cookie_id, $auth->parro_cookie_path, $auth->parro_cookie_domain);
            Funciones::destroy_cookie($auth->parro_cookie_token, $auth->parro_cookie_path, $auth->parro_cookie_domain);

            return false;
        }

        // Verificamos que exista el usuario con base a la información de nuestro cookie
        if (!$auth->current_user = Model::list($auth->parro_users_table, ['id' => Funciones::get_cookie($auth->parro_cookie_id)], 1)) {
            return false;
        }

        // Información del usuario
        $user        = $auth->current_user;
        $auth_token  = $user['auth_token'];
        $auth->token = Funciones::get_cookie($auth->parro_cookie_token);

        // Verificamos si coincide la información
        if (!password_verify($auth->token, $auth_token)) {
            // Si no existe la coincidencia vamos a borrar los cookies por seguridad
            Funciones::destroy_cookie($auth->parro_cookie_id, $auth->parro_cookie_path, $auth->parro_cookie_domain);
            Funciones::destroy_cookie($auth->parro_cookie_token, $auth->parro_cookie_path, $auth->parro_cookie_domain);

            return false;
        }

        return $user; // return $user si todo es correcto
    }

    /**
     * Inicia la sesión persistente del usuario en curso
     * @access public
     * @var array
     * @return bool
     **/
    public static function new_session($id)
    {
        // Nueva instancia para usar las propiedades de la clase
        $auth  = new self();

        // Creamos un nuevo token
        $token = Funciones::generate_token();

        // Cargamos la información del usuario
        $user  = Model::list($auth->parro_users_table, ['id' => $id], 1);

        if (empty($user)) {
            return false; // no existe el usuario en curso
        }

        // Verificamos si existen los cookies para borrarlos y generar nuevos
        if (Funciones::cookie_exists($auth->parro_cookie_id) || Funciones::cookie_exists($auth->parro_cookie_token)) {
            // Si existen los borramos
            Funciones::destroy_cookie($auth->parro_cookie_id, $auth->parro_cookie_path, $auth->parro_cookie_domain);
            Funciones::destroy_cookie($auth->parro_cookie_token, $auth->parro_cookie_path, $auth->parro_cookie_domain);
        }

        // Creamos nuevos cookies
        Funciones::new_cookie($auth->parro_cookie_id, $id, $auth->parro_cookie_lifetime, $auth->parro_cookie_path, $auth->parro_cookie_domain);
        Funciones::new_cookie($auth->parro_cookie_token, $token, $auth->parro_cookie_lifetime, $auth->parro_cookie_path, $auth->parro_cookie_domain);

        // Actualizamos el token en la base de datos
        Model::update($auth->parro_users_table, ['id' => $id], ['auth_token' => password_hash($token, PASSWORD_BCRYPT)]);

        return true;
    }

    /**
     * Utilizada para destruir una sesión persistente de nuestro usuario
     * loggeado en el sistema
     *
     * @return bool
     */
    public static function destroy_session()
    {
        $auth = new self();

        // Se destruyen todos los tokens generados para que sea imposible el ingreso con ese mismo token después
        if (!Model::update($auth->parro_users_table, ['id' => Funciones::get_cookie($auth->parro_cookie_id)], ['auth_token' => ''])) {
            return false;
        }

        // Se destruyen todos los cookies existentes
        Funciones::destroy_cookie($auth->parro_cookie_id, $auth->parro_cookie_path, $auth->parro_cookie_domain);
        Funciones::destroy_cookie($auth->parro_cookie_token, $auth->parro_cookie_path, $auth->parro_cookie_domain);

        // Se regresa true si se borra todo con éxito
        return true;
    }

    public static function getMenuDynamic()
    {
        $results = "";
        try {
            // Nueva instancia para usar las propiedades de la clase
            $auth  = new self();

            $queries = Database::query("SELECT p.id, p.controllers, p.methods, p.name, p.icons, p.icons, p.parent_id
                                      FROM $auth->parro_permissions_table as p
                                      INNER JOIN $auth->parro_users_permissions_table as up ON up.permission_id = p.id 
                                      INNER JOIN $auth->parro_users_table as u ON u.id = up.user_id
                                      WHERE p.parent_id is null
                                      ");

            foreach ($queries as $query) {
                
                $iconAngle = "";
                $active = "";
                $queries2 = Database::query("SELECT p.controllers, p.methods, p.name, p.icons, p.icons, p.parent_id
                                      FROM $auth->parro_permissions_table as p
                                      WHERE p.parent_id = {$query['id']}");

                if (!empty($queries2)) {
                    $iconAngle = "<i class=\"right fas fa-angle-left\"></i>";
                }

                if(str_contains(REQUEST_URI, $query['controllers'].'/'.$query['methods'])){
                    $active = "active";
                }

                if(REQUEST_URI == URL){
                    
                }

                $results .= "<li class=\"nav-item\">
                                <a href=\"{$query['controllers']}/{$query['methods']}\" class=\"nav-link $active\">
                                    <i class=\"nav-icon {$query['icons']}\"></i>
                                    <p>
                                        {$query['name']}
                                        $iconAngle";
                $results .=        "</p>
                                </a>";
                if (!empty($queries2)) {
                    foreach ($queries2 as $query2) {
                        $results .= "<ul class=\"nav nav-treeview\">
                                    <li class=\"nav-item\">
                                        <a href=\"{$query2['controllers']}/{$query2['methods']}\" class=\"nav-link\">
                                            <i class=\"far fa-circle nav-icon\"></i>
                                            <p>{$query2['name']}</p>
                                        </a>
                                    </li>             
                                </ul>";
                    }
                }

                $results .= "</li>";
            }
        } catch (Exception $e) {
            Funciones::logger("Error al traer el menú dinámico en ParroSession.php: " . $e->getMessage());
        }

        return $results;
    }
}
