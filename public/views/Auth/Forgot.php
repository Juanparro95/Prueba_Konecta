<?php
    use ParroFramework\Functions\Funciones;
?>

<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="../../index2.html" class="h1"><b>PARRO</b>Network</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg"><?php echo $d->title; ?></p>

      <form method="post">
      <?= Funciones::insert_inputs(); ?>
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Correo Electrónico">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <!-- /.social-auth-links -->
      <p class="mb-0 mt-3">
        <a href="Auth" class="text-center">Ya recordé mi contraseña</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>