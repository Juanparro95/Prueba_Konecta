<?php 

namespace ParroFramework\Configs;

use Auth;

class Controller {

  function __construct()
  {
  }

  /**
   * Función para validar la sesión de un usuario, puede ser usada
   * en cualquier controlador hijo o que extienda el Controller
   *
   * @return void
   */
  function auth()
  {
    if (!Auth::validate()) {
      Flasher::new('Área protegida, debes iniciar sesión para visualizar el contenido.', 'danger');
      Redirect::back('login');
    }
  }
}