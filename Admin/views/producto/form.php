<div class="ps-5 pe-5 pt-3 my-container active-cont">
  <form action="producto.php?action=<?php echo (isset($datos)) ? 'update' : 'save'; ?>" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="exampleFormControlInput1">Producto</label>
      <input type="text" name="producto[producto]" value="<?php echo (isset($datos[0]['producto'])) ? $datos[0]['producto'] : ''; ?>" class="form-control" id="producto" placeholder="Producto">
    </div>
    <div class="mb-3">
      <label for="exampleFormControlInput1">Precio</label>
      <input type="text" name="producto[precio]" value="<?php echo (isset($datos[0]['precio'])) ? $datos[0]['precio'] : ''; ?>" class="form-control" id="precio" placeholder="precio">
    </div>
    <div class="mb-3">
      <label for="exampleFormControlInput1">Tipo producto</label>
      <select name="producto[id_tipo_producto]" class="form-select">
        <?php
        foreach ($tipos as $key => $tipo) :
          $selected = '';
          if ($tipo['id_tipo_producto'] == $datos[0]['id_tipo_producto']) {
            $selected = ' selected';
          }
        ?>
          <option value="<?php echo ($tipo['id_tipo_producto']) ?>" <?php echo ($selected); ?>><?php echo ($tipo['tipo_producto']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3">
      <input type="hidden" name="producto[id_producto]" value="<?php echo (isset($datos[0]['id_producto'])) ? $datos[0]['id_producto'] : ''; ?>">
      <input type="submit" name="enviar" value="Guardar" class="btn btn-success" />
    </div>
  </form>
</div>