<link href="/your-path-to-fontawesome/css/fontawesome.css" rel="stylesheet">
<link href="/your-path-to-fontawesome/css/brands.css" rel="stylesheet">
<link href="/your-path-to-fontawesome/css/solid.css" rel="stylesheet">
<!--style type="text/css"-->
<table class="table">
  <thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">tipo Producto</th>
      <th scope="col"><a href="producto.php?ordenamiento=p.producto">Producto</a></th>
      <th scope="col"><a href="producto.php?ordenamiento=p.precio">Precio</a></th>
      <th scope="col">Modificar</i></th>
      <!--Historial-->
      <th scope="col">Eliminar</th>
      <!--Eliminar-->
    </tr>
  </thead>
  <tbody>
    <h1>Productos</h1>
    <div class="d-flex flex-row-reverse">
      <form action="producto.php" method="get">
        <input class="input-group-text" style="display:inline-block;" type="text" name="busqueda">
        <input class="btn btn-outline-secondary" type="submit" name="buscar">
      </form>
    </div>
    <a href="producto.php?action=create" class="btn btn-success"><i class="fa fa-plus p-1 icons"></i>Agregar</a>
    <?php foreach ($datos as $key => $producto) : ?>
      <tr>
        <th scope="row"><?= $producto['id_producto'] ?></th>
        <!--id-->
        <td><?= $producto['tipo_producto'] ?></td>
        <!--nombre-->
        <td><?= $producto['producto'] ?></td>
        <!--apaterno-->
        <td><?= $producto['precio'] ?></td>
        <!--amaterno-->
        <td><a href="producto.php?action=show&id_producto=<?= $producto['id_producto'] ?>" class="btn btn-info"><i class="fa fa-arrow-up p-1 icons"></i>Modificar</a></td>
        <!--modificar-->
        <td><a href="producto.php?action=delete&id_producto=<?= $producto['id_producto'] ?>" class="btn btn-danger"><i class="fa fa-trash p-1 icons"></i>Eliminar</a></td>
        <!--eliminar-->

      </tr>
    <?php endforeach; ?>
  </tbody>

</table>
<nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item"><a class="page-link" href="#">PREREVIEWS</a></li>
    <?php for ($i = 0; $i < $productos->total(); $i += 5) : ?>
      <li class="page-item"><a class="page-link" href="producto.php?<?php echo (isset($_GET['busqueda'])) ? 'busqueda=' . $_GET['busqueda'] . '&' : ''; ?>&desde=<?php echo $i; ?>&limite=5"><?php echo $i / 5 ?></a></li>
    <?php endfor; ?>
    <li class="page-item"><a class="page-link" href="#">Next</a></li>
  </ul>
</nav>

<?php
echo "Filtrando" . count($datos) . " de un total de" . $productos->total() . " productos.";
?>