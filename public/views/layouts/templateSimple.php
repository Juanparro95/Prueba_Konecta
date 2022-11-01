<?php

use ParroFramework\Functions\Funciones;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <base href="<?php echo BASEPATH; ?>">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($d->title) ? $d->title . ' - ' . Funciones::get_sitename() : 'Bienvenido - ' . Funciones::get_sitename(); ?></title>
    <?php Funciones::get_favicon() ?>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= PLUGINS_TEMPLATE ?>fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= DIST_CSS_TEMPLATE ?>adminlte.min.css">
    <!-- Sweet Alert -->    
    <link rel="stylesheet" href="<?=PLUGINS_TEMPLATE.'sweetalert2-theme-bootstrap-4/bootstrap-4.min.css'?>"/>
    <!-- Waitme css -->
    <link rel="stylesheet" href="<?=PLUGINS_TEMPLATE.'waitme/waitMe.min.css'; ?>">
    <!-- Estilos registrados manualmente -->
    <?php echo Funciones::load_styles(); ?>
</head>

<body class="hold-transition login-page">

    <?php include_once($_SESSION['PARRO_VIEW']) ?>

    <!-- jQuery -->
    <script src="<?= PLUGINS_TEMPLATE ?>jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= PLUGINS_TEMPLATE ?>bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= DIST_JS_TEMPLATE ?>adminlte.min.js"></script>
    <!-- Sweet Alert -->    
    <script src="<?=PLUGINS_TEMPLATE.'sweetalert2/sweetalert2.min.js'?>"></script>
    <!-- waitme js -->
    <script src="<?php echo PLUGINS_TEMPLATE.'waitme/waitMe.min.js'; ?>"></script>
    <!-- Lightbox js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <!-- Configuración Global -->
    <script src="<?= JS ?>Global.js"></script>

    <!-- Objeto Parro Javascript registrado -->
    <?php echo Funciones::load_parro_obj(); ?>

    <!-- Scripts registrados manualmente -->
    <?php echo Funciones::load_scripts(); ?>

</body>

</html>