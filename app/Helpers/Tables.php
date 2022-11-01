<?php 

/**
 * SECCIÓN DONDE SE ALMACENA LOS NOMBRES DE LAS TABLAS CON SU EXTENSION DE SEGURIDAD
 */

define('SALT_DB', $_ENV['SALT_DB']);

// Tablas creadas por defecto
define('KONECTA_USERS_TABLE', SALT_DB.'users');         // Nombre de la tabla para autenticación de usuarios
define('KONECTA_PRODUCTS_TABLE', SALT_DB.'products');         // Nombre de la tabla de los productos
define('KONECTA_SHOPPING_TABLE', SALT_DB.'shoppings');         // Nombre de la tabla para las categorias
define('KONECTA_CATEGORIES_TABLE', SALT_DB.'categories');         // Nombre de la tabla para las categorias

