<link href="/your-path-to-fontawesome/css/fontawesome.css" rel="stylesheet">
<link href="/your-path-to-fontawesome/css/brands.css" rel="stylesheet">
<link href="/your-path-to-fontawesome/css/solid.css" rel="stylesheet">
<!--style type="text/css"-->
<table class="table">
  <thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">tipo Producto</th>
      <th scope="col">Modificar</i></th>
      <!--Historial-->
      <th scope="col">Eliminar</th>
      <!--Eliminar-->
    </tr>
  </thead>
  <tbody>
    <h1>Tipo de productos</h1>
    <div class="d-flex flex-row-reverse">
      <form action="tipo_producto.php" method="get">
        <input class="input-group-text" style="display:inline-block;" type="text" name="busqueda">
        <input class="btn btn-outline-secondary" type="submit" name="buscar">
      </form>
    </div>
    <a href="tipo_producto.php?action=create" class="btn btn-success"><i class="fa fa-plus p-1 icons"></i> Agregar</a>
    <?php foreach ($datos as $key => $tipo_producto) : ?>
      <tr>
        <th scope="row"><?= $tipo_producto['id_tipo_producto'] ?></th>
        <!--id-->
        <td><?= $tipo_producto['tipo_producto'] ?></td>
        <!--nombre-->
        <td><a href="tipo_producto.php?action=show&id_tipo_producto=<?= $tipo_producto['id_tipo_producto'] ?>" class="btn btn-info"><i class="fa fa-arrow-up p-1 icons"></i>Modificar</a></td>
        <!--modificar-->
        <td><a href="tipo_producto.php?action=delete&id_tipo_producto=<?= $tipo_producto['id_tipo_producto'] ?>" class="btn btn-danger"><i class="fa fa-trash p-1 icons"></i>Eliminar</a></td>
        <!--eliminar-->

      </tr>
    <?php endforeach; ?>
  </tbody>

</table>