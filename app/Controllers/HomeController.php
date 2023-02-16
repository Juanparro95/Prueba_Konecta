<?php

class HomeController extends Controller
{
  function __construct()
  {
     // Validación de sesión de usuario, descomentar si requerida
    if (!Auth::validate()) {
      Flasher::new('Debes iniciar sesión primero.', 'danger');
      Redirect::to('Auth');
    }
  }

  function index()
  {
    $data =
      [
        'title' => 'Página de inicio',
        'bg'    => 'dark'
      ];
    View::render('index', $data);
  }

      /**
     * Metodo para cerrar sesión
     *
     * @return void
     */
    public function logout()
    {
        if (!Auth::validate()) {
            Flasher::new('No hay una sesión iniciada, no podemos cerrarla.', 'danger');
            Redirect::to('Auth');
          }
      
          Auth::logout();
          Redirect::to('Auth');
    }
}
