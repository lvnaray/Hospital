<link href="/your-path-to-fontawesome/css/fontawesome.css" rel="stylesheet">
<link href="/your-path-to-fontawesome/css/brands.css" rel="stylesheet">
<link href="/your-path-to-fontawesome/css/solid.css" rel="stylesheet">
<!--style type="text/css"-->
<table class="table">
  <thead>
    <tr>
      <th scope="col">id usuario</th>
      <th scope="col">id_rol</th>
      <th scope="col">Modificar</i></th>
      <!--Historial-->
      <th scope="col">Eliminar</th>
      <!--Eliminar-->
    </tr>
  </thead>
  <tbody>

    <div class="d-flex flex-row-reverse">
      <form action="usuario_rol.php" method="get">
        <input class="input-group-text" style="display:inline-block;" type="text" name="busqueda">
        <input class="btn btn-outline-secondary" type="submit" name="buscar">
      </form>
    </div>
    <a href="usuario_rol.php?action=create" class="btn btn-success">Agregar</a>
    <?php foreach ($datos as $key => $usuario_rol) : ?>
      <tr>
        <th scope="row"><?= $usuario_rol['id_usuario'] ?></th>
        <!--id-->
        <td><?= $usuario_rol['id_rol'] ?></td>
        <!--nombre-->
        <td><a href="usuario_rol.php?action=show&id_usuario=<?= $usuario_rol['id_usuario'] ?>" class="btn btn-info">Modificar</a></td>
        <!--modificar-->
        <td><a href="usuario_rol.php?action=delete&id_usuario=<?= $usuario_rol['id_usuario'] ?>" class="btn btn-danger">Eliminar</a></td>
        <!--eliminar-->

      </tr>
    <?php endforeach; ?>
  </tbody>

</table>