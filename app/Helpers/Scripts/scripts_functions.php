<?php

use ParroFramework\Functions\Funciones;

/**
 * Retorna los css de la libreria Datatables
 *
 * @return void
 */
function scripts_datatables()
{
    Funciones::register_scripts(PLUGINS_TEMPLATE.'datatables/jquery.dataTables.min.js', 'SCRIPTS DATATABLES');
    Funciones::register_scripts(PLUGINS_TEMPLATE.'datatables-bs4/js/dataTables.bootstrap4.min.js', '');
    Funciones::register_scripts(PLUGINS_TEMPLATE.'datatables-responsive/js/dataTables.responsive.min.js', '');
    Funciones::register_scripts(PLUGINS_TEMPLATE.'datatables-responsive/js/responsive.bootstrap4.min.js', '');
    Funciones::register_scripts(PLUGINS_TEMPLATE.'datatables-buttons/js/dataTables.buttons.min.js', '');
    Funciones::register_scripts(PLUGINS_TEMPLATE.'datatables-buttons/js/buttons.bootstrap4.min.js', '');
    Funciones::register_scripts(PLUGINS_TEMPLATE.'jszip/jszip.min.js', '');
    Funciones::register_scripts(PLUGINS_TEMPLATE.'pdfmake/pdfmake.min.js', '');
    Funciones::register_scripts(PLUGINS_TEMPLATE.'pdfmake/vfs_fonts.js', '');
    Funciones::register_scripts(PLUGINS_TEMPLATE.'datatables-buttons/js/buttons.html5.min.js', '');
    Funciones::register_scripts(PLUGINS_TEMPLATE.'datatables-buttons/js/buttons.print.min.js', '');
    Funciones::register_scripts(PLUGINS_TEMPLATE.'datatables-buttons/js/buttons.colVis.min.js', '');
}

/**
 * Retorna el script de los graficos Chart.js
 *
 * @return void
 */
function scripts_chart_js()
{
    Funciones::register_scripts(PLUGINS_TEMPLATE.'chart.js/Chart.min.js', 'ChartJS');
}

/**
 * Retorna el script de Full Calendar
 *
 * @return void
 */
function scripts_full_calendar()
{
    scripts_moment_js();
    Funciones::register_scripts(PLUGINS_TEMPLATE.'fullcalendar/main.js', 'Full Calendar');
}

/**
 * Retorna el script de Moment.js
 *
 * @return void
 */
function scripts_moment_js()
{
    Funciones::register_scripts(PLUGINS_TEMPLATE.'moment/moment.min.js', 'Full Calendar');
}