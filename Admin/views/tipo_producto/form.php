<div class="ps-5 pe-5 pt-3 my-container active-cont">
  <form action="tipo_producto.php?action=<?php echo(isset($datos))? 'update': 'save';?>" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="exampleFormControlInput1">Tipo producto</label>
      <input type="text" name="tipo_producto[tipo_producto]" value="<?php echo (isset($datos[0]['tipo_producto']))?$datos[0]['tipo_producto']:'';?>" class="form-control" id="tipo_producto" placeholder="Tipo_producto" >
    </div>
    
    <div class="form-group">
    <input type="hidden" name="tipo_producto[id_tipo_producto]" value="<?php echo (isset($datos[0]['id_tipo_producto']))?$datos[0]['id_tipo_producto']:'';?>">
      <input type="submit" name="enviar" value="Guardar" class="btn btn-success" />
    </div>
  </form>
</div>
  