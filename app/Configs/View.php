<?php

namespace ParroFramework\Configs;

use ParroFramework\Functions\Funciones;

class View
{

  /**
   * Método que retorna al usuario a la vista seleccionada
   *
   * @param [type] $view
   * @param array $data
   * @param integer $default / 0 = Template Normal, 1 = Template Simple Ej. Login, Register, Errors
   * @return void
   */
  public static function render($view, $data = [], $default = 0)
  {
    // Convertir el array asociativo en objeto
    $d = Funciones::to_object($data); // $data en array assoc o $d en objectos
    $controller = CONTROLLER;

    if($default == TEMPLATE_AUTH)
    {
      $controller = 'Auth';
    }

    if (!is_file(VIEWS . $controller . DS . $view . '.php')) {
      die(sprintf('No existe la vista "%sView" en la carpeta "%s".', $view, $controller));
    }

    $_SESSION['PARRO_VIEW'] = VIEWS . $controller . DS . $view . '.php';

    if ($default == TEMPLATE_SIMPLE || $default == TEMPLATE_AUTH) {
      require_once('public/views/layouts/templateSimple.php');
      exit;
    }

    require_once('public/views/layouts/template.php');
  }
}
