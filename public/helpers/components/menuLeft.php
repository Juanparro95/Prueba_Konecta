<?php

use ParroFramework\Functions\Funciones;
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?= URL ?>" class="brand-link">
    <img src="<?= IMAGES . SITE_LOGO ?>" alt="<?= Funciones::get_sitename() . " Logo" ?>" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light"><?= Funciones::get_sitename() ?></span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?php echo IMAGES . 'user.jpg'; ?>" class="img-circle elevation-2" alt="<?= Funciones::getUser('name') ?>">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?= Funciones::getUser('username') ?></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-legacy" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

        <li class="nav-item">
          <a href="javascript:void(0)" class="nav-link $active">
            <i class="fas fa-utensils"></i>
            <p>
              Cafetería <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="product" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>CRUD</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="shopping" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>TIENDA</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="home/logout" class="nav-link $active">
            <i class="fas fa-sign-out-alt"></i>
            <p>
              Cerrar Sesión
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>