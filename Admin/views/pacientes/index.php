<link href="/your-path-to-fontawesome/css/fontawesome.css" rel="stylesheet">
<link href="/your-path-to-fontawesome/css/brands.css" rel="stylesheet">
<link href="/your-path-to-fontawesome/css/solid.css" rel="stylesheet">
<!--style type="text/css"-->
<table class="table">
  <thead>
    <tr>
      <th scope="col">Folio</th>
      <th scope="col">Foto de perfil</th>
      <th scope="col">Nombre</th>
      <th scope="col">Apellido Paterno</th>
      <th scope="col">Apellido Materno</th>
      <th scope="col">Nacimiento</th>
      <th scope="col">Domicilio</th>
      <th scope="col">Modificar</th><!--Modificar-->
      <th scope="col">Historial</i></th><!--Historial-->
      <th scope="col">Eliminar</th><!--Eliminar-->
    </tr>
  </thead>
  <tbody>
  <h1>Pacientes</h1>
  <div class="mb-3">
    <a href="pacientes.php?action=create" class="btn btn-success"><i class="fas fa-user-plus"></i>Agregar</a>
    <a href="pacientes.report.php" class="btn btn-dark"> <i class="fas fa-file-medical"></i>Crear reporte</a>
  </div>
  <?php foreach($datos as $key => $paciente):?>
    <tr>
      <th scope="row"><?=$paciente['id_paciente'] ?></th><!--id-->
      <td><img src="<?php echo (isset($paciente['fotografia']))? 'archivos/'.$paciente['fotografia']: 'archivos/default.jpg'; ?>" alt="foto paciente" class="rounded-circle img-fluid" width="100px"></td>
      <td><?=$paciente['nombre'] ?></td><!--nombre-->
      <td><?=$paciente['apaterno'] ?></td><!--apaterno-->
      <td><?=$paciente['amaterno'] ?></td><!--amaterno-->
      <td><?=$paciente['nacimiento'] ?></td><!--nacimiento-->
      <td><?=$paciente['domicilio'] ?></td><!--domicilio-->
      <td><a href="pacientes.php?action=show&id_paciente=<?=$paciente['id_paciente'] ?>" class="btn btn-info">Actualizar</a></td><!--modificar-->
      <td><a href="pacientes.php?action=consulta&id_paciente=<?=$paciente['id_paciente'] ?>" class="btn btn-info">Info</a></td><!--modificar-->
      <td><a href="pacientes.php?action=delete&id_paciente=<?=$paciente['id_paciente'] ?>" class="btn btn-danger">Eliminar</a></td><!--eliminar-->

    </tr>
  <?php endforeach;?>
  </tbody>
</table>