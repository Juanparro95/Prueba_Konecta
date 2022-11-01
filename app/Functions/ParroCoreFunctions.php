<?php

namespace ParroFramework\Functions;

use Exception;

class Funciones
{
    /**
     * Convierte el elemento en un objecto
     *
     * @param [type] $array
     * @return void
     */
    public static function to_object($array)
    {
        return json_decode(json_encode($array));
    }

    /**
     * Regresa el nombre de nuestra aplicación
     *
     * @return string
     */
    public static function get_sitename()
    {
        return SITE_NAME;
    }

    /**
     * Regresa la versión de nuestro sistema actual
     *
     * @return string
     */
    public static function get_version()
    {
        return SITE_VERSION;
    }

    /**
     * Regresa el nombre del framework Parro Framework
     *
     * @return string
     */
    public static function get_parro_name()
    {
        return PARRO_NAME;
    }

    /**
     * Regresa la versión del framework actual
     *
     * @return string
     */
    public static function get_parro_version()
    {
        return PARRO_VERSION;
    }

    /**
     * Devuelve el email general del sistema
     *
     * @return string
     */
    public static function get_siteemail()
    {
        return 'jslocal@localhost.com';
    }

    /**
     * Regresa la fecha de estos momentos
     *
     * @return string
     */
    public static function now()
    {
        return date('Y-m-d H:i:s');
    }



    /**
     * Sanitiza un valor ingresado por usuario
     *
     * @param string $str
     * @param boolean $cleanhtml
     * @return string
     */
    public static function clean($str, $cleanhtml = false)
    {
        $str = @trim(@rtrim($str));

        // if (get_magic_quotes_gpc()) {
        // 	$str = stripslashes($str);
        // }

        if ($cleanhtml === true) {
            return htmlspecialchars($str);
        }

        return filter_var($str, FILTER_SANITIZE_STRING);
    }

    /**
     * Loggea un registro en un archivo de logs del sistema, usado para debugging
     *
     * @param string $message
     * @param string $type
     * @param boolean $output
     * @return mixed
     */
    public static function logger($message, $type = 'debug', $output = false)
    {
        $types = ['debug', 'import', 'info', 'success', 'warning', 'error'];

        if (!in_array($type, $types)) {
            $type = 'debug';
        }

        $now_time = date("d-m-Y H:i:s");

        $message = is_array($message) || is_object($message) ? print_r($message, true) : $message;
        $message = "[" . strtoupper($type) . "] $now_time - $message";

        if (!is_dir(LOGS)) {
            mkdir(LOGS);
        }

        if (!$fh = fopen(LOGS . "parro_log.log", 'a')) {
            error_log(sprintf('Can not open this file on %s', LOGS . 'parro_log.log'));
            return false;
        }

        fwrite($fh, "$message\n");
        fclose($fh);
        if ($output) {
            print "$message\n";
        }

        return true;
    }

    /**
     * Carga y regresa un valor determinao de la información del usuario
     * guardada en la variable de sesión actual
     *
     * @param string $key
     * @return mixed
     */
    public static function getUser($key = null)
    {
        if (!isset($_SESSION['user_session'])) return false;

        $session = $_SESSION['user_session']; // información de la sesión del usuario actual, regresará siempre falso si no hay dicha sesión

        if (!isset($session['user']) || empty($session['user'])) return false;

        $user = $session['user']; // información de la base de datos o directamente insertada del usuario

        if ($key === null) return $user;

        if (!isset($user[$key])) return false; // regresará falso en caso de no encontrar el key buscado

        // Regresa la información del usuario
        return $user[$key];
    }

    /**
     * Generar un link dinámico con parámetros get y token
     * 
     */
    public static function buildURL($url, $params = [], $redirection = true, $csrf = true)
    {

        // Check if theres a ?
        $query     = parse_url($url, PHP_URL_QUERY);
        $_params[] = 'hook=' . strtolower(SITE_NAME);
        $_params[] = 'action=doing-task';

        // Si requiere token csrf
        if ($csrf) {
            $_params[] = '_t=' . CSRF_TOKEN;
        }

        // Si requiere redirección
        if ($redirection) {
            $_params[] = 'redirect_to=' . urlencode(CUR_PAGE);
        }

        // Si no es un array regresa la url original
        if (!is_array($params)) {
            return $url;
        }

        // Listando parámetros
        foreach ($params as $key => $value) {
            $_params[] = sprintf('%s=%s', urlencode($key), urlencode($value));
        }

        $url .= strpos($url, '?') ? '&' : '?';
        $url .= implode('&', $_params);
        return $url;
    }

    /**
     * Creación de un token de 32 caractores por defecto
     *
     * @param integer $length
     * @return string
     */
    public static function generate_token($length = 32)
    {
        $token = null;
        if (function_exists('bin2hex')) {
            $token = bin2hex(random_bytes($length)); // ASDFUHASIO32Jasdasdjf349mfjads9mfas4asdf
        } else {
            $token = bin2hex(openssl_random_pseudo_bytes($length)); // asdfuhasi487a9s49mafmsau84
        }

        return $token;
    }


    public static function persistent_session()
    {
        if (!defined('PARRO_COOKIES') || PARRO_COOKIES !== true) {
            return false;
        }
        return true;
    }

    /**
     * Carga la información de un cookie en caso de existir
     *
     * @param string $cookie
     * @return bool | true si existe | false si no
     */
    public static function cookie_exists($cookie)
    {
        return isset($_COOKIE[$cookie]);
    }

    /**
     * Creamos un cookie directamente
     * con base a los parámetros pasados
     *
     * @param array $cookies
     * @return void
     */
    public static function new_cookie($name, $value, $lifetime = null, $path = '', $domain = '')
    {
        // Para prevenir cualquier error de ejecución
        // al ser enviadas ya las cabeceras del sitio
        if (headers_sent()) {
            return false;
        }

        // Valor por defecto de la duración del cookie
        $default  = 60 * 60 * 24; // 1 día por defecto si no existe la constante
        $lifetime = defined('PARRO_COOKIE_LIFETIME') && $lifetime === null ? PARRO_COOKIE_LIFETIME : (!is_integer($lifetime) ? $default : $lifetime);

        // Creamos el nuevo cookie
        setcookie($name, $value, time() + $lifetime, $path, $domain);

        return true;
    }

    /**
     * Borrar cookies en caso de existir,
     * se pasa el nombre de cada cookie como parámetro array
     *
     * @param array $cookies
     * @return bool
     */
    public static function destroy_cookie($cookie, $path = '', $domain = '')
    {
        global $parroCookies;

        // Para prevenir cualquier error de ejecución
        // al ser enviadas ya las cabeceras del sitio
        if (headers_sent()) {
            return false;
        }

        // Verificamos que exista el cookie dentro de nuestra
        // global, si no existe entonces no existe el cookie en sí
        if (!isset($_COOKIE[$cookie])) {
            return false;
        }

        // Seteamos el cookie con un valor null y tiempo negativo para destruirlo
        setcookie($cookie, null, time() - 1000, $path, $domain);
        unset($parroCookies[$cookie]);

        return true;
    }

    /**
     * Verifica si existe un determinado cookie creado
     *
     * @param string $cookie_name
     * @return mixed
     */
    public static function get_cookie($cookie)
    {
        return isset($_COOKIE[$cookie]) ? $_COOKIE[$cookie] : false;
    }

    /**
     * Función estándar para realizar
     * un die de sitio con Parro framework
     * muestra contenido html5 de forma más estética
     *
     * @param string $message
     * @param array $headers
     * @return mixed
     */
    public static function parro_die($message, $headers = [])
    {
        if (!is_string($message)) {
            throw new Exception('El parámetro $message debe ser un string válido.');
        }

        if (empty($headers)) {
            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
        }

        die($message);
    }

    /**
     * Cargar y regresa todos los cookies del sitio
     *
     * @return array
     */
    public static function get_all_cookies()
    {
        $cookies = [];

        if (!isset($_COOKIE) || empty($_COOKIE)) {
            return $cookies;
        }

        // Iteramos entre todos los cookies guardados del sitio
        // para almacenarlos en una nueva variable
        foreach ($_COOKIE as $name => $value) {
            $cookies[$name] = $value;
        }

        return $cookies;
    }

    /**
     * Códificar a json de forma especial para prevenir errores en UTF8
     *
     * @param mixed $var
     * @return string
     */
    public static function json_encode_utf8($var)
    {
        return json_encode($var, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Regresa la api key pública para consumir las rutas de la API
     *
     * @return string
     */
    public static function get_parro_api_public_key()
    {
        $name = 'API_PUBLIC_KEY';
        if (!defined($name)) {
            throw new Exception(sprintf('La constante %s no existe o no se ha definido en el sistema y es requerida para esta función.', $name));
        }

        $key = API_PUBLIC_KEY;
        return $key;
    }

    /**
     * Carga el objeto Bee registrado y todos sus valores
     * por defecto y personalizados
     *
     * @return string
     */
    public static function load_parro_obj()
    {
        global $parroObject;
        $output = '';

        if (empty($parroObject)) {
            return $output;
        }

        $output = '<script>const Parro = %s </script>';

        return sprintf($output, self::json_encode_utf8($parroObject));
    }

    /**
     * Registra los parámetro por defecto de Parro Framework
     *
     * @return bool
     */
    public static function parro_obj_default_config()
    {
        $options =
            [
                'sitename'      => self::get_sitename(),
                'version'       => self::get_version(),
                'parro_name'      => self::get_parro_name(),
                'parro_version'   => self::get_parro_version(),
                'csrf'          => CSRF_TOKEN,
                'url'           => URL,
                'cur_page'      => CUR_PAGE,
                'basepath'      => BASEPATH,
                'request_uri'   => REQUEST_URI,
                'assets'        => ASSETS,
                'images'        => IMAGES,
                'uploaded'      => UPLOADED,
                'php_version'   => phpversion(),
                'public_key'    => self::get_parro_api_public_key()
            ];

        return $options;
    }

    /**
     * Para registrar una hoja de estilos de forma manual
     *
     * @param array $stylesheets
     * @param string $comment
     * @return bool
     */
    public static function register_styles($stylesheets, $comment = null)
    {
        global $parroStyles;

        $parroStyles[] =
            [
                'comment' => (!empty($comment) ? $comment : null),
                'files'   => $stylesheets
            ];

        return true;
    }

    /**
     * Para registrar uno o más scripts de forma manual
     *
     * @param array $scripts
     * @param string $comment
     * @return bool
     */
    public static function register_scripts($scripts, $comment = null)
    {
        global $parroScripts;

        $parroScripts[] =
            [
                'comment' => (!empty($comment) ? $comment : null),
                'files'   => $scripts
            ];

        return true;
    }

    /**
     * Inserta campos htlm en un formulario
     *
     * @return string
     */
    public static function insert_inputs()
    {
        $output = '';

        if (isset($_POST['redirect_to'])) {
            $location = $_POST['redirect_to'];
        } else if (isset($_GET['redirect_to'])) {
            $location = $_GET['redirect_to'];
        } else {
            $location = CUR_PAGE;
        }

        $output .= '<input type="hidden" name="redirect_to" value="' . $location . '">';
        $output .= '<input type="hidden" name="timecheck" value="' . time() . '">';
        $output .= '<input type="hidden" name="csrf" value="' . CSRF_TOKEN . '">';

        return $output;
    }

    /**
     * Valida los parámetros pasados en POST
     *
     * @param array $required_params
     * @param array $posted_data
     * @return void
     */
    public static function check_posted_data($required_params = [], $posted_data = [])
    {

        if (empty($posted_data)) {
            return false;
        }

        // Keys necesarios en toda petición
        $required_params = array_merge($required_params);
        $required = count($required_params);
        $found = 0;

        foreach ($posted_data as $k => $v) {
            if (in_array($k, $required_params)) {
                $found++;
            }
        }

        if ($found != $required) {
            return false;
        }

        return true;
    }

    /**
     * Carga los estilos registrados de forma manual
     * por la función register_styles()
     *
     * @return string
     */
    public static function load_styles()
    {
        global $parroStyles;
        $output = '';

        if (empty($parroStyles)) {
            return $output;
        }

        // Iterar sobre cada elemento registrado
        foreach (json_decode(json_encode($parroStyles)) as $css) {
            if ($css->comment) {
                $output .= '<!-- ' . $css->comment . ' -->' . "\n";
            }

            // Iterar sobre cada path de archivo registrado
            foreach ($css->files as $f) {
                $output .= "\t" . '<link rel="stylesheet" href="' . $f . '" >' . "\n";
            }
        }

        return $output;
    }


    /**
     * Carga los scrips registrados de forma manual
     * por la función register_scripts()
     *
     * @return string
     */
    public static function load_scripts()
    {
        global $parroScripts;
        $output = '';

        if (empty($parroScripts)) {
            return $output;
        }

        // Itera sobre todos los elementos registrados
        foreach (json_decode(json_encode($parroScripts)) as $js) {
            if ($js->comment) {
                $output .= '<!-- ' . $js->comment . ' -->' . "\n";
            }

            // Itera sobre todos los paths registrados
            foreach ($js->files as $f) {
                $output .= '<script src="' . $f . '" type="text/javascript"></script>' . "\n";
            }
        }

        return $output;
    }

    /**
     * Carga todos los mensajes configurados por defecto para
     * su uso en el sistema de Bee framework
     *
     * @return array
     */
    public static function get_parro_default_messages()
    {
        $messages =
            [
                '0'           => 'Acceso no autorizado.',
                '1'           => 'Acción no autorizada.',
                '2'           => 'Ocurrió un error, intenta más tarde.',
                '3'           => 'No pudimos procesar tu solicitud.',
                'added'       => 'Nuevo registro agregado con éxito.',
                'not_added'   => 'Hubo un problema al agregar el registro.',
                'updated'     => 'Registro actualizado con éxito.',
                'not_updated' => 'Hubo un problema al actualizar el registro.',
                'found'       => 'Registro encontrado con éxito.',
                'not_found'   => 'El registro no existe o ha sido borrado.',
                'deleted'     => 'Registro borrado con éxito.',
                'not_deleted' => 'Hubo un problema al borrar el registro.',
                'sent'        => 'Mensaje enviado con éxito.',
                'not_sent'    => 'Hubo un problema al enviar el mensaje.',
                'sent_to'     => 'Mensaje enviado con éxito a %s.',
                'not_sent_to' => 'Hubo un problema al enviar el mensaje a %s.',
                'auth'        => 'Debes iniciar sesión para continuar.',
                'expired'     => 'La sesión ha expirado, vuelve a ingresar por favor.',
                'm_params'    => 'Parámetros incompletos, acceso no autorizado.',
                'm_form'      => 'Campos incompletos, completa el formulario por favor.',
                'm_token'     => 'Token no encontrado o no válido, acceso no autorizado.'
            ];

        return $messages;
    }

    /**
     * Registar un nuevo valor para el objeto Bee
     * insertado en el pie del sitio como objeto para
     * acceder a los parámetros de forma sencilla
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public static function register_to_parro_obj($key, $value)
    {
        global $parroObject;

        /**
         * Formateo del key en caso de no ser válido para
         * javascript
         * @since 1.1.4
         */
        $key = str_replace([' ', '-'], '_', $key);

        if (is_array($value) || is_object($value)) {
            $parroObject[$key] = $value;
        } else {
            $parroObject[$key] = self::clean($value);
        }

        return true;
    }

    /**
     * Carga un mensaje de bee framework existente
     * en el array de la global Bee_Messages
     * 
     * OPCIONES ACTUALES
     * 
     * 
     * '0'           => 'Acceso no autorizado.'
     * '1'           => 'Acción no autorizada.'
     * '2'           => 'Ocurrió un error, intenta más tarde.'
     * '3'           => 'No pudimos procesar tu solicitud.'
     * 'added'       => 'Nuevo registro agregado con éxito.'
     * 'not_added'   => 'Hubo un problema al agregar el registro.'
     * 'updated'     => 'Registro actualizado con éxito.'
     * 'not_updated' => 'Hubo un problema al actualizar el registro.'
     * 'found'       => 'Registro encontrado con éxito.'
     * 'not_found'   => 'El registro no existe o ha sido borrado.'
     * 'deleted'     => 'Registro borrado con éxito.'
     * 'not_deleted' => 'Hubo un problema al borrar el registro.'
     * 'sent'        => 'Mensaje enviado con éxito.'
     * 'not_sent'    => 'Hubo un problema al enviar el mensaje.'
     * 'sent_to'     => 'Mensaje enviado con éxito a %s.'
     * 'not_sent_to' => 'Hubo un problema al enviar el mensaje a %s.'
     * 'auth'        => 'Debes iniciar sesión para continuar.'
     * 'expired'     => 'La sesión ha expirado, vuelve a ingresar por favor.'
     * 'm_params'    => 'Parámetros incompletos, acceso no autorizado.'
     * 'm_form'      => 'Campos incompletos, completa el formulario por favor.'
     * 'm_token'     => 'Token no encontrado o no válido, acceso no autorizado.' 
     * 
     * @param string $code
     * @return mixed
     */
    public static function get_parro_message($code)
    {
        global $Bee_Messages;

        $code = (string) $code;

        return isset($Bee_Messages[$code]) ? $Bee_Messages[$code] : '';
    }

    /**
     * Regresa la api key privada para consumir las rutas de la API
     *
     * @return string
     */
    public static function get_parro_api_private_key()
    {
        $name = 'API_PRIVATE_KEY';
        if (!defined($name)) {
            throw new Exception(sprintf('La constante %s no existe o no se ha definido en el sistema y es requerida para esta función.', $name));
        }

        $key = API_PRIVATE_KEY;
        return $key;
    }

    /**
     * Regresa true si es requerida autenticación con api keys para consumir los
     * recursos de la API de parro framework y la instancia actual
     *
     * @return bool
     */
    public static function parro_api_authentication()
    {
        $name = 'API_AUTH';
        if (!defined($name)) {
            throw new Exception(sprintf('La constante %s no existe o no se ha definido en el sistema y es requerida para esta función.', $name));
        }

        return (API_AUTH === true);
    }


    /**
     * Hace output en el body como json
     *
     * @param array $json
     * @param boolean $die
     * @return void
     */
    public static function json_output($json, $die = true)
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json;charset=utf-8');

        if (is_array($json)) {
            $json = json_encode($json);
        }

        echo $json;
        if ($die) {
            die;
        }

        return true;
    }

    /**
     * Construye un nuevo string json
     *
     * @param integer $status
     * @param array $data
     * @param string $msg
     * @return void
     */
    public static function json_build($status = 200, $data = null, $msg = '', $error_code = null)
    {
        /*
    1 xx : Informational
    2 xx : Success
    3 xx : Redirection
    4 xx : Client Error
    5 xx : Server Error
    */

        if (empty($msg) || $msg == '') {
            switch ($status) {
                case 200:
                    $msg = 'OK';
                    break;
                case 201:
                    $msg = 'Created';
                    break;
                case 400:
                    $msg = 'Invalid request';
                    break;
                case 403:
                    $msg = 'Access denied';
                    break;
                case 404:
                    $msg = 'Not found';
                    break;
                case 500:
                    $msg = 'Internal Server Error';
                    break;
                case 550:
                    $msg = 'Permission denied';
                    break;
                default:
                    break;
            }
        }

        $json =
            [
                'status' => $status,
                'error'  => false,
                'msg'    => $msg,
                'data'   => $data
            ];

        if (in_array($status, [400, 403, 404, 405, 500])) {
            $json['error'] = true;
        }

        if ($error_code !== null) {
            $json['error'] = $error_code;
        }

        return json_encode($json);
    }


    /**
     * Regresa el favicon del sitio con base 
     * al archivo definido en la función
     * por defecto el nombre de archivo es favicon.ico y se encuentra en la carpeta favicon
     *
     * @return mixed
     */
    public static function get_favicon()
    {
        $path        = FAVICON; // path del archivo favicon
        $favicon     = SITE_FAVICON; // nombre del archivo favicon
        $type        = '';
        $href        = '';
        $placeholder = '<link rel="icon" type="%s" href="%s">';

        switch (pathinfo($path . $favicon, PATHINFO_EXTENSION)) {
            case 'ico':
                $type = 'image/vnd.microsoft.icon';
                $href = $path . $favicon;
                break;

            case 'png':
                $type = 'image/png';
                $href = $path . $favicon;
                break;

            case 'gif':
                $type = 'image/gif';
                $href = $path . $favicon;
                break;

            case 'svg':
                $type = 'image/svg+xml';
                $href = $path . $favicon;
                break;

            case 'jpg':
            case 'jpeg':
                $type = 'image/jpg';
                $href = $path . $favicon;
                break;

            default:
                return false;
                break;
        }

        return sprintf($placeholder, $type, $href);
    }
}
