<?php

class ErrorController extends Controller {
  function __construct()
  {
  }
  
  function index() {
    $data =
    [
      'title' => 'Página no encontrada',
    ];

    Funciones::logger('Hubo un error al querer ingresar a la ruta: '.CUR_PAGE.' revisar de maneja urgente el problema', ERRORES_LOG[1]);

    View::render('404', $data, 1);
  }
}