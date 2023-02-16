<?php

/**
 * ! Clase Principal -> Configuración por defecto del Framework
 */

class Parro
{

    // Nombre Identificador del Framwork
    private $framework = "Parro Framework";
    // Versión del framework
    private $version = "1.0.0";

    /**
     * @since 1.1.4
     *
     * @var string
     */
    private $current_controller = null;
    private $controller = null;
    private $current_method = null;
    private $method = null;
    private $params    = [];
    private $cont_not_found = false;
    private $method_not_found   = false;
    private $missing_params = false;
    private $is_ajax = false;
    private $is_api = false;
    private $uri = [];

    // Metodo constructor del Modelo Parro
    function __construct()
    {
        $this->init();
    }

    private function init()
    {
        $this->init_session();
        $this->init_cargar_config();
        $this->init_cargar_funciones();
        $this->init_autoload();
        $this->init_csrf();
        $this->init_globals();
        $this->init_autenticacion();
        $this->init_set_globals();
        $this->init_custom();
        $this->init_filtros_url();
        $this->init_set_defaults();
        $this->init_dispatch();
    }

    /**
     * Metodo que inicia la sesión del sistema
     *
     * @return void
     */
    private function init_session()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        return;
    }

    /**
     * Método que carga los archivos iniciales de configuración
     *
     * @return void
     */
    private function init_cargar_config()
    {
        // Nombre del archivo de configuración principal, contiene constantes iniciales.
        $file = 'ParroHelpers.php';

        if (!is_file("app/Helpers/$file")) {
            throw new Exception(sprintf('El archivo %s no se encuentra, es requerido para que %s funcione.', $file, $this->framework));
        }

        // Se carga el archivo con las constantes iniciales
        require_once "app/Helpers/$file";

        // Nombre del archivo de configuración principal, contiene constantes iniciales.
        $file = 'Tables.php';

        if (!is_file("app/Helpers/$file")) {
            throw new Exception(sprintf('El archivo %s no se encuentra, es requerido para que %s funcione.', $file, $this->framework));
        }

        // Se carga el archivo con las constantes iniciales
        require_once "app/Helpers/$file";
        // Nombre del archivo de configuración principal, contiene constantes iniciales.
        $file = 'ParroSettings.php';

        if (!is_file("app/Helpers/$file")) {
            throw new Exception(sprintf('El archivo %s no se encuentra, es requerido para que %s funcione.', $file, $this->framework));
        }

        // Se carga el archivo con las constantes iniciales
        require_once "app/Helpers/$file";

        // Nombre del archivo de validación
        $file = 'ParroValidators.php';

        if (!is_file("app/Helpers/$file")) {
            throw new Exception(sprintf('El archivo %s no se encuentra, es requerido para que %s funcione.', $file, $this->framework));
        }

        // Se carga el archivo con las constantes iniciales
        require_once "app/Helpers/$file";

        return;
    }

    /**
     * Método que carga las funciones iniciales del sistema
     *
     * @return void
     */
    private function init_cargar_funciones()
    {
        // Nombre del archivo de configuración principal, contiene constantes iniciales.
        $file = 'ParroCoreFunctions.php';

        if (!is_file("app/Functions/$file")) {
            throw new Exception(sprintf('El archivo %s no se encuentra, es requerido para que %s funcione.', $file, $this->framework));
        }

        // Se carga el archivo con las constantes iniciales
        require_once "app/Functions/$file";

        // Nombre del archivo de configuración principal, contiene constantes iniciales.
        $file = 'ParroCustomFunctions.php';

        if (!is_file("app/Functions/$file")) {
            throw new Exception(sprintf('El archivo %s no se encuentra, es requerido para que %s funcione.', $file, $this->framework));
        }

        // Se carga el archivo con las constantes iniciales
        require_once "app/Functions/$file";

        return;
    }

    /**
     * Metodo que inicializa composer
     *
     * @return void
     */
    public static function init_composer()
    {
        $file = 'vendor/autoload.php';

        if (!is_file($file)) {
            throw new Exception(sprintf('El archivo %s no se encuentra, es requerido para que %s funcione.', $file));
        }

        require $file;

        // Cargando composer
        $file = ".env";
        if (!is_file($file)) {
            throw new Exception(sprintf('El archivo %s no se encuentra, es requerido para que %s funcione.', $file));
        }

        return;
    }


    /**
     * Método para cargar todos los archivos de forma automática
     *
     * @return void
     */
    private function init_autoload()
    {
        require_once CONFIG . 'Autoloader.php';
        Autoloader::init();
        return;
    }

    /**
     * Método para crear un nuevo token de la sesión del usuario
     *
     * @return void
     */
    private function init_csrf()
    {
        $csrf = new Csrf();
        define('CSRF_TOKEN', $csrf->get_token()); // Versión 1.0.2 para uso en aplicaciones
    }

    /**
     * Inicializa las globales del sistema
     *
     * @return void
     */
    private function init_globals()
    {
        //////////////////////////////////////////////
        // Globales generales usadas en el framework
        //////////////////////////////////////////////

        // Cookies del sitio
        $GLOBALS['PARRO_COOKIES']  = [];

        // Define si un usuario está loggeado o no y su información actual
        $GLOBALS['PARRO_USER']     = [];

        // Del sistema
        $GLOBALS['PARRO_SETTINGS'] = [];

        // Objeto Bee que será insertado en el footer como script javascript dinámico para fácil acceso
        $GLOBALS['PARRO_OBJECTS']   = [];

        // Define los mensajes por defecto para usar en notificaciones o errores
        $GLOBALS['PARRO_MESSAGES'] = [];
    }

    /**
     * Inicia la validación de sesión en caso de existir 
     * sesiones persistentes de Bee framework
     *
     * @return void
     */
    private function init_autenticacion()
    {
        global $parroUser;

        // Mantener la sesión del usuario abierta al ser persistente

        if (Funciones::persistent_session()) {
            $user = ParroSession::authenticate();

            // En caso de que validación sea negativa y exista una sesión en curso abierta
            // se destruye para prevenir cualquier error o ataque
            if ($user === false && Auth::validate()) {
                //Auth::logout();

                return true; // para prevenir que siga ejecutando
            }

            // En esta parte se puede cargar información diferente o adicional del usuario
            // ya que sabemos que su autenticación es válida
            ////////////////////////////////////

            $parroUser = !empty($user) ? $user : [];
            // ---> $user = usuarioModel::by_id($id);

            ////////////////////////////////////
            // Se agrega la información del usuario a sesión
            if (!empty($parroUser)) {
                /**
                 * Para prevenir la regeneración del token e id de sesión
                 * en caso de que ya haya ocurrido un inicio de sesión previo
                 */
                if (!Auth::validate()) {
                    Auth::login($parroUser['id'], $parroUser);
                }
            }

            return true;
        }
    }

    /**
     * Set up inicial de todas las variables globales requeridas
     * en el sistema
     *
     * @return void
     */
    private function init_set_globals()
    {
        global $parroCookies, $parroMessages, $parroObjects;
        // Inicializa y carga todas las cookies existentes del sitio
        $parroCookies   = Funciones::get_all_cookies();
        // Inicializa el objeto javascript para el pie de página
        $parroObjects    = Funciones::parro_obj_default_config();
        // Inicializa y carga todos los mensajes por defecto de Bee framework
        $parroMessages  = Funciones::get_parro_default_messages();
    }


    /**
     * Usado para carga de procesos personalizados del sistema
     * funciones, variables, set up
     *
     * @return void
     */
    private function init_custom()
    {
        /**
         * No son necesarios pero es recomendados tenerlos de forma
         * global registrados aquí, para poder acceder desde todo el sistema
         * dentro de Javascript
         * @since 1.1.4
         */
        Funciones::register_to_parro_obj('current_controller', $this->current_controller);
        Funciones::register_to_parro_obj('current_method', $this->current_method);
        Funciones::register_to_parro_obj('current_params', $this->params);


        // Inicializar procesos personalizados del sistema o aplicación
        // ........
    }

    /**
     * Método para filtrar y descomponer los elementos de nuestra url y uri
     *
     * @return void
     */
    private function init_filtros_url()
    {
        if (isset($_GET['uri'])) {
            $this->uri = $_GET['uri'];
            $this->uri = rtrim($this->uri, '/');
            $this->uri = filter_var($this->uri, FILTER_SANITIZE_URL);
            $this->uri = explode('/', $this->uri);
            return $this->uri;
        }
    }

    /**
     * Iteramos sobre los elementos de la uri
     * para descomponer los elementos que necesitamos
     * controller
     * method
     * params
     * 
     * Definimos las diferentes constantes que ayudan al sistema Bee
     * a funcionar de forma correcta
     *
     * @return void
     */
    private function init_set_defaults()
    {
        /////////////////////////////////////////////////////////////////////////////////
        // Necesitamos saber si se está pasando el nombre de un controlador en nuestro URI
        // $this->uri[0] es el controlador en cuestión
        if (isset($this->uri[0])) {
            $this->current_controller = ucfirst($this->uri[0]); // users Controller.php
            unset($this->uri[0]);
        } else {
            $this->current_controller = DEFAULT_CONTROLLER; // home Controler.php establecido en settings.php
        }

        // Validando si la petición entrante original es ajax
        if (in_array($this->current_controller, ['ajax'])) {
            $this->is_ajax            = true; // Lo usaremos para filtrar más adelante nuestro tipo de respuesta al usuario
        }

        // Validando si la petición entrante original es de consumo de la API
        if (in_array($this->current_controller, ['api', 'v1', 'v2', 'v3'])) {
            $this->is_api = true; // Lo usaremos para filtrar más adelante nuestro tipo de respuesta al usuario
        }

        // Definiendo el nombre del archivo del controlador
        $this->controller           = $this->current_controller . 'Controller'; // homeController

        // Verificamos si no existe la clase buscada, se asigna la por defecto si no existe
        if (!class_exists($this->controller)) {
            $this->current_controller = DEFAULT_ERROR_CONTROLLER; // Para que el CONTROLLER sea error
            $this->controller         = DEFAULT_ERROR_CONTROLLER . 'Controller'; // errorController
            $this->cont_not_found     = true; // No se ha encontrado la clase o controlador en el sistema
        }

        /////////////////////////////////////////////////////////////////////////////////
        // Ejecución del método solicitado
        if (isset($this->uri[1])) {
            $this->method = str_replace('-', '_', ucfirst($this->uri[1]));


            // Existe o no el método dentro de la clase a ejecutar (controllador)
            if (!method_exists($this->controller, $this->method)) {
                $this->current_controller = DEFAULT_ERROR_CONTROLLER; // controlador de errores por defecto
                $this->controller         = DEFAULT_ERROR_CONTROLLER . 'Controller'; // errorController
                $this->current_method     = DEFAULT_METHOD; // método index por defecto
                $this->method_not_found   = true; // el método de la clase no existe
            } else {
                $this->current_method     = $this->method;
            }

            unset($this->uri[1]);
        } else {
            $this->current_method       = DEFAULT_METHOD; // index
        }
        // Verificar que el método solicitado sea público de lo contrario no se da acceso
        $reflection = new ReflectionMethod($this->controller, $this->current_method);
        if (!$reflection->isPublic()) {
            // Si el método solicitado no es público, se manda a ruta de error
            $this->current_controller = DEFAULT_ERROR_CONTROLLER; // controlador de errores por defecto
            $this->controller         = DEFAULT_ERROR_CONTROLLER . 'Controller'; // errorController
            $this->current_method     = DEFAULT_METHOD; // método index por defecto
        }

        // Obteniendo los parámetros de la URI
        $this->params = array_values(empty($this->uri) ? [] : $this->uri);

        /**
         * Verifica el tipo de petición que se está solicitando
         * @since 1.1.4
         */
        $this->init_check_request_type();

        /////////////////////////////////////////////////////////////////////////////////
        // Creando constantes para utilizar más adelante
        define('CONTROLLER', $this->current_controller);
        define('METHOD', $this->current_method);
    }

    /**
     * Verifica el tipo de petición que está recibiendo nuestro
     * sistema, para setear una constante que nos ayudará a filtrar
     * ciertas acciones a realizar al inicio
     *
     * @return void
     */
    private function init_check_request_type()
    {
        /**
         * Recontruye los valores por defecto si es una petición ajax o a la API
         * @since 1.1.4
         */
        if ($this->is_ajax === true) {
            $this->current_controller = 'ajax';
            $this->controller         = sprintf('%sController', $this->current_controller);
        } elseif ($this->is_api === true) {
            $this->current_controller = 'api';
            $this->controller         = sprintf('%sController', $this->current_controller);
        }

        switch ($this->current_controller) {
            case 'ajax':
            case 'api':

                if ($this->current_controller === 'ajax') {
                    define('DOING_AJAX', true);
                } else {
                    define('DOING_API', true);
                }

                // En caso de que no exista la ruta solicitada
                if ($this->method_not_found === true) {
                    $this->current_method = DEFAULT_METHOD;
                }

                break;

            case 'cronjob':
                define('DOING_CRON', true);
                break;

            case 'xml':
                define('DOING_XML', true);
                break;

            default:
                break;
        }
    }

    /**
     * Método para ejecutar y cargar de forma automática el controlador solicitado por el usuario
     * su método y pasar parámetros a él.
     *
     * @return bool
     */
    private function init_dispatch()
    {
        /////////////////////////////////////////////////////////////////////////////////
        // Ejecutando controlador y método según se haga la petición
        $this->controller = new $this->controller;

        // Llamada al método que solicita el usuario en curso
        if (empty($this->params)) {
            call_user_func([$this->controller, $this->current_method]);
        } else {
            call_user_func_array([$this->controller, $this->current_method], $this->params);
        }

        return true; // Línea final todo sucede entre esta línea y el comienzo
    }



    public static function run()
    {
        $parro = new self();
        return;
    }
}
