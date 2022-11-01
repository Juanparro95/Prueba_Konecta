<?php

use ParroFramework\Configs\Model;
use ParroFramework\Configs\PaginationHandler;

class Product extends Model
{
    /**
     * Metodo que obtiene todos los productos de la cafetería
     *
     * @return retorna listado Paginado
     */
    static function all_paginated()
    {
      $sql = "SELECT * FROM ".KONECTA_PRODUCTS_TABLE." ORDER BY id ASC";
      return PaginationHandler::paginate($sql);
    }
}