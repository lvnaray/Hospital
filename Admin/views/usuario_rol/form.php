<form action="usuario_rol.php?action=<?php echo (isset($datos)) ? 'update' : 'save'; ?>" method="POST" enctype="multipart/form-data">
  <div class="form-group">
    <label for="exampleFormControlInput1">id_rol</label>
    <input type="text" name="usuario_rol[id_rol]" value="<?php echo (isset($datos[0]['id_rol'])) ? $datos[0]['id_rol'] : ''; ?>" class="form-control" id="id_rol" placeholder="id_rol">

  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">usuario</label>
    <select name="usuario_rol[id_usuario]" class="form-select">
      <?php
      foreach ($tipos as $key => $tipo) :
        $selected = '';
        if ($tipo['id_usuario'] == $datos[0]['id_usuario']) {
          $selected = ' selected';
        }
      ?>
        <option value="<?php echo ($tipo['id_usuario']) ?>" <?php echo ($selected); ?>><?php echo ($tipo['id_rol']) ?></option>
      <?php endforeach; ?>
    </select>

  </div>

  <div class="form-group">
    <label for="exampleFormControlInput1">usuario</label>
    <select name="usuario_rol[id_rol]" class="form-select">
      <?php
      foreach ($tipos as $key => $tipo) :
        $selected = '';
        if ($tipo['id_rol'] == $datos[0]['id_rol']) {
          $selected = ' selected';
        }
      ?>
        <option value="<?php echo ($tipo['id_rol']) ?>" <?php echo ($selected); ?>><?php echo ($tipo['id_usuario']) ?></option>
      <?php endforeach; ?>
    </select>

  </div>


  </div>
  <div class="form-group">
    <input type="hidden" name="tipo_producto[id_tipo_producto]" value="<?php echo (isset($datos[0]['id_tipo_producto'])) ? $datos[0]['id_tipo_producto'] : ''; ?>">
    <input type="submit" name="enviar" value="Guardar" class="btn btn-success" />
  </div>