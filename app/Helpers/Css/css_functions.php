<?php

use ParroFramework\Functions\Funciones;

/**
 * Retorna los css de la libreria Datatables
 *
 * @return void
 */
function css_datatables()
{
    Funciones::register_styles(PLUGINS_TEMPLATE.'datatables-bs4/css/dataTables.bootstrap4.min.css', 'CSS DATATABLES');
    Funciones::register_styles(PLUGINS_TEMPLATE.'datatables-responsive/css/responsive.bootstrap4.min.css', '');
    Funciones::register_styles(PLUGINS_TEMPLATE.'datatables-buttons/css/buttons.bootstrap4.min.css', '');
}

/**
 * Retorna los estilos de Calendar
 *
 * @return void
 */
function css_calendar()
{
    Funciones::register_styles(PLUGINS_TEMPLATE.'fullcalendar/main.css', 'CSS FULL CALENDAR');
}