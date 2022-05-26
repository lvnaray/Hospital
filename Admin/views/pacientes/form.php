<?php if (isset($datos[0]['fotografia'])) : ?>
  <img src="archivos/<?php echo ($datos[0]['fotografia']); ?>" class="rounded-circle" widht="200" height="200">
<?php endif; ?>
<h1>Pacientes</h1>
<form action="pacientes.php?action=<?php echo (isset($datos)) ? 'update' : 'save'; ?>" method="POST" enctype="multipart/form-data">
  <div class="form-group">
    <label for="exampleFormControlInput1">Nombre</label>
    <input type="text" name="paciente[nombre]" value="<?php echo (isset($datos[0]['nombre'])) ? $datos[0]['nombre'] : ''; ?>" class="form-control" id="nombre" placeholder="Nombre">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Apellido Paterno</label>
    <input type="text" name="paciente[apaterno]" value="<?php echo (isset($datos[0]['apaterno'])) ? $datos[0]['apaterno'] : ''; ?>" class="form-control" id="apaterno" placeholder="Apellido Paterno">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Apellido Materno</label>
    <input type="text" name="paciente[amaterno]" value="<?php echo (isset($datos[0]['amaterno'])) ? $datos[0]['amaterno'] : ''; ?>" class="form-control" id="amaterno" placeholder="Apellido Materno">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Nacimiento</label>
    <input type="text" name="paciente[nacimiento]" value="<?php echo (isset($datos[0]['nacimiento'])) ? $datos[0]['nacimiento'] : ''; ?>" class="form-control" id="nacimiento" placeholder="Nacimiento">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Domicilio</label>
    <input type="text" name="paciente[domicilio]" value="<?php echo (isset($datos[0]['domicilio'])) ? $datos[0]['domicilio'] : ''; ?>" class="form-control" id="domicilio" placeholder="Domicilio">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Fotografia</label>
    <input type="file" name="fotografia" class="form-control" id="domicilio" placeholder="Domicilio">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Correo</label>
    <input type="text" name="paciente[correo]" value="<?php echo (isset($datos[0]['correo'])) ? $datos[0]['correo'] : ''; ?>" class="form-control" id="correo" placeholder="correo">
  </div>

  <div class="form-group">
    <input type="hidden" name="paciente[id_paciente]" value="<?php echo (isset($datos[0]['id_paciente'])) ? $datos[0]['id_paciente'] : ''; ?>">
    <input type="submit" name="enviar" value="Guardar" class="btn btn-success" />
  </div>
</form>