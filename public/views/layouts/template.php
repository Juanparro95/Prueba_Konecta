<?php

use ParroFramework\Configs\ParroSession;
use ParroFramework\Functions\Funciones;

use function ParroFramework\Helpers\debug;

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
    <link rel="stylesheet" href="<?=PLUGINS_TEMPLATE?>fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=DIST_CSS_TEMPLATE?>adminlte.min.css">
    <!-- Sweet Alert -->    
    <link rel="stylesheet" href="<?=PLUGINS_TEMPLATE.'sweetalert2-theme-bootstrap-4/bootstrap-4.min.css'?>"/>
    <!-- Estilos registrados manualmente -->
    <?php echo Funciones::load_styles(); ?>
</head>

<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <?php include_once(COMPONENTS_VIEW . "menuTop.php") ?>
  <!-- /.navbar -->
  <?php include_once(COMPONENTS_VIEW . "menuLeft.php") ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo $d->title ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Blank Page</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <?php include_once($_SESSION['PARRO_VIEW']) ?>
      

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> <?=Funciones::get_version()?>
    </div>
    <strong>Copyright &copy; <?= date('Y') ?> <a href="https://adminlte.io"><?=Funciones::get_sitename() ?></a>.</strong> Todos los derechos reservados.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>


    <!-- jQuery -->
    <script src="<?=PLUGINS_TEMPLATE?>jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?=PLUGINS_TEMPLATE?>bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?=DIST_JS_TEMPLATE?>adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?=DIST_JS_TEMPLATE?>demo.js"></script>
    <!-- Sweet Alert -->    
    <script src="<?=PLUGINS_TEMPLATE.'sweetalert2/sweetalert2.min.js'?>"></script>

    <script src="<?php echo PLUGINS_TEMPLATE.'waitme/waitMe.min.js'; ?>"></script>

    <script src="<?=JS?>Global.js"></script>

        <!-- Objeto Bee Javascript registrado -->
    <?php echo Funciones::load_parro_obj(); ?>

    <!-- Scripts registrados manualmente -->
    <?php echo Funciones::load_scripts(); ?>
</body>

</html>