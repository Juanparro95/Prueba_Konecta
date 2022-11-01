<?php

use ParroFramework\Configs\Model;
use ParroFramework\Configs\PaginationHandler;

class Shopping extends Model
{
    public static function getAll()
    {
        $sql = 'SELECT P.name, S.amount FROM '.KONECTA_PRODUCTS_TABLE.' AS P JOIN '.KONECTA_SHOPPING_TABLE.' AS S ON S.product_id = P.id ORDER BY S.id DESC';
        return ($rows = parent::query($sql)) ? $rows : [];
    }
}