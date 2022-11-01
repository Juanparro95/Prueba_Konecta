<?php

/**
 *  ! Clase Helpers, contiene constantes iniciales del sistema para que funcione correctamente.
 */

/**
 * Keys para consumo de la API de esta instancia de Parro Framework
 * puedes regenerarlas en parro/generate
 * @since 1.1.4
 */

define('API_PUBLIC_KEY', '03d427-c4034c-d2dc71-373b10-36da67');
define('API_PRIVATE_KEY', '51362e-0cb1b9-f9c183-17b0a3-1a002e');

define('API_AUTH', true);

define('CSS_FRAMEWORK', 'bs5'); // opciones disponibles: bs o bs5 = Bootstrap 5 | bl = Bulma | fn = Foundation


// Datos de la empresa / negocio / sistema
define('SITE_CHARSET', 'UTF-8');
define('SITE_NAME', $_ENV['APP_NAME']);    // Nombre del sitio
define('SITE_VERSION', '1.0.0');          // Versión del sitio
define('SITE_LOGO', 'logo.png');       // Nombre del archivo del logotipo base
define('SITE_FAVICON', 'favicon.ico');    // Nombre del archivo del favicon base
define('SITE_DESC', 'Prueba Konecta.'); // Descripción meta del sitio

// Versión de la aplicación
define('PARRO_NAME', $this->framework); // Viene desde Parro.php
define('PARRO_VERSION', $this->version);   // Viene desde Parro.php
define('BASEPATH',  "/".$_ENV['ROUTE']."/");

// Puerto y la URL del sitio
define('PROTOCOL', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http"); // Detectar si está en HTTPS o HTTP
define('HOST', $_SERVER['HTTP_HOST'] === 'localhost' ? 'localhost' : $_SERVER['HTTP_HOST']); // Dominio o host localhost.com tudominio.com
define('REQUEST_URI', $_SERVER["REQUEST_URI"]); // Parámetros y ruta requerida
define('URL', PROTOCOL . '://' . HOST . BASEPATH); // URL del sitio
define('CUR_PAGE', PROTOCOL . '://' . HOST . REQUEST_URI); // URL actual incluyendo parámetros get

// Las rutas de directorios y archivos
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', getcwd() . DS);

define('APP', ROOT . 'app' . DS);
define('CONFIG', APP . 'Configs' . DS);
define('CONTROLLERS', APP . 'Controllers' . DS);
define('FUNCTIONS', APP . 'Functions' . DS);
define('MODELS', APP . 'Models' . DS);
define('RESOURCES', ROOT . 'resources' . DS);
define('LOGS', RESOURCES . 'Logs' . DS);

define('PUBLICS', ROOT . 'public' . DS);
define('INCLUDES', PUBLICS . 'includes' . DS);
define('MODULES', PUBLICS . 'modules' . DS);
define('VIEWS', PUBLICS . 'views' . DS);
define('COMPONENTS_VIEW', PUBLICS . 'helpers/components' . DS);
define('TABLES_VIEW', PUBLICS . 'helpers/tables' . DS);

// Rutas de recursos y assets absolutos
define('IMAGES_PATH', ROOT . 'assets' . DS . 'images' . DS);

// Rutas de archivos o assets con base URL
define('ASSETS', URL . 'assets/');
define('CSS', ASSETS . 'css/');
define('FAVICON', ASSETS . 'favicon/');
define('FONTS', ASSETS . 'fonts/');
define('IMAGES', ASSETS . 'images/');
define('IMAGES_COMPANY', IMAGES . 'company/');
define('JS', ASSETS . 'js/');
define('COMPONENTS', JS . 'components/');
define('PLUGINS', ASSETS . 'plugins/');
define('UPLOADS', ROOT . 'assets' . DS . 'uploads' . DS);
define('UPLOADED', ASSETS . 'uploads/');

// Rutas plantillas
define('TEMPLATES', URL . 'templates/');
define('DIST_TEMPLATE', TEMPLATES . 'dist/');
define('DIST_CSS_TEMPLATE', DIST_TEMPLATE . 'css/');
define('DIST_JS_TEMPLATE', DIST_TEMPLATE . 'js/');
define('PLUGINS_TEMPLATE', TEMPLATES . 'plugins/');

// Tipos de plantillas
define('TEMPLATE_SIMPLE', 1);
define('TEMPLATE_AUTH', 2);


// Sesiones de usuario persistentes
define('PARRO_COOKIES', true);                // Es utilizada para determinar si se usarán sesiones persistentes con cookies en el sistema
define('PARRO_COOKIE_ID', 'parro__cookie_id');    // Nombre del cookie para el identificador de usuario
define('PARRO_COOKIE_TOKEN', 'parro__cookie_tkn');   // Nombre del cookie para el token generado para usuario
define('PARRO_COOKIE_LIFETIME', 60 * 60 * 24 * 7);    // Duración o vida de un cookie para cada usuario, por defecto 1 semana
define('PARRO_COOKIE_PATH', '/');
define('PARRO_COOKIE_DOMAIN', '');

// El controlador por defecto / el método por defecto / el controlador de errores por defecto
define('DEFAULT_CONTROLLER', 'Home');
define('DEFAULT_ERROR_CONTROLLER', 'Error');
define('DEFAULT_METHOD', 'index');

const ERRORES_LOG = [
  0 => 'debug',
  1 => 'import',
  2 => 'info',
  3 => 'success',
  4 => 'warning',
  5 => 'error'
];


/**
 * Muestra en pantalla los valores pasados
 *
 * @param mixed $data
 * @return void
 */
function debug($data)
{
  echo '<pre>';
  if (is_array($data) || is_object($data)) {
    print_r($data);
  } else {
    echo $data;
  }
  echo '</pre>';

  exit;
}
