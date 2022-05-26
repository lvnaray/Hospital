<form action="../login/login.php?action=savePass" method="POST">
  <div class="form-group">
    <label for="exampleInputEmail1">Nueva contraseña</label>
    <input type="password" name="contrasena" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
  </div>
  <input type="hidden" name="correo" value="<?php echo ($correo) ?>">
  <input type="hidden" name="token" value="<?php echo ($token) ?>">
  <input type="submit" name="enviar" value="Reestablecer contraseña" class="btn btn-primary"></button>
</form>