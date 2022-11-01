<?php

use ParroFramework\Configs\Flasher;
use ParroFramework\Functions\Funciones;
?>

<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="../../index2.html" class="h1"><b>PARRO</b>Network</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Inicia sesión para continuar</p>

      <form method="post" action="auth/login">
      <?php echo Flasher::flash(); ?>

        <?= Funciones::insert_inputs(); ?>
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Correo Electrónico">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Contraseña">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Recordarme
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mb-0">
        <a href="Auth/register" class="text-center">Soy nuevo, deseo registrarme</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>