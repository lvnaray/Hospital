<div class="modal-dialog text-center">
  <div class="col-sm-12 main-section">
    <div class="modal-content">
      <div class="d-flex flex-column justify-content-center align-items-center">
        <div class="w-100 p-3 text-center" style="background-color: #eee;font-size: 17px;">
          <form action="../login/login.php?action=validate" method="POST">
            <img src="../images/logo.png" widht="80" height="200" class="rounded-circle">
            <div class="mb-3">
              <label for="exampleInputEmail1">Correo electrónico</label>
              <input type="email" name="correo" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="porejemplo@gmail.com">
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1">Contraseña</label>
              <input type="password" name="contrasena" class="form-control" id="exampleInputPassword1" placeholder="contraseña">
            </div>
            <input type="submit" name="enviar" value="Ingresar" class="btn btn-primary"></button>
            <br>
            <a href=../login/login.php?action=forget>¿Olvidó su contraseña</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>