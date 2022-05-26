<div class="d-flex flex-column justify-content-center align-items-center">
  <div class="w-100 p-3 text-center" style="background-color: #eee;font-size: 17px;">
    <img src="<?php echo (isset($datos[0]['fotografia'])) ? 'archivos/' . $datos[0]['fotografia'] : 'archivos/default.jpg'; ?>" widht="80" height="200" class="rounded-circle">
    <h3>Nombre: <?php echo $datos[0]['nombre']; ?></h3>
    <h3>Apellido Paterno: <?php echo $datos[0]['apaterno']; ?></h3>
    <h3>Apellido materno: <?php echo $datos[0]['amaterno']; ?></h3>
    <h3>Edad: <?php echo $datos[0]['edad']; ?></h3>
    <div>
      <a class="btn btn-success mb-3" href="pacientesapi.php?action=exportarOne&id_paciente=<?= $datos[0]['id_paciente'] ?>" class="btn btn-info">Exportar</a>
    </div>
    <h3>NUEVA CONSULTA</h3>
    <form action="pacientes.php?action=consulta_nueva" method="POST">
      <div class="form-group">
        <label for="exampleInputEmail1">Padecimiento</label>
        <input class="form-control" name="consulta[padecimiento]" id="exampleInputEmail1" aria-describedby="emailHelp">
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Tratamiento</label>
        <input class="form-control" name="consulta[tratamiento]" id="exampleInputPassword1">
      </div>
      <div>
        <input type="hidden" name="consulta[id_paciente]" value="<?php echo (isset($datos[0]['id_paciente'])) ? $datos[0]['id_paciente'] : ''; ?>">
        <input type="submit" name="enviar" value="Guardar consulta" class="btn btn-success" />
      </div>
    </form>
    <BR>
  </div>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">ID consulta</th>
        <th scope="col">FECHA</th>
        <th scope="col">PADECIMIENTO</th>
        <th scope="col">DOCTOR</th>
        <th scope="col">BOTONES</th>

      </tr>
    </thead>
    <tbody>
      <h1>CONSULTAS</h1>
      <?php foreach ($consultas as $key => $consulta) : ?>
        <tr>
          <th scope="row"><?= $consulta['id_consulta'] ?></th>
          <!--id-->
          <td><?= $consulta['fecha'] ?></td>
          <!--nombre-->
          <td><?= $consulta['padecimiento'] ?></td>
          <!--apaterno-->
          <td><?= $consulta['doctor'] ?></td>
          <!--amaterno-->

          <td><button type="button" class="btn btn-primary openBtn" data-toggle="modal" data-target=".bd-example-modal-lg" data-href="verReceta.php?id_consulta=<?= $consulta['id_consulta'] ?>">
              Generar receta
            </button>
          </td>
          <!--modificar-->
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">RECETA</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="contenido">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>
<script>
  $('.openBtn').on('click', function() {
    var dataURL = $(this).attr('data-href');
    $('#contenido').load(dataURL, function() {
      $('#myModal').modal({
        show: true
      });
    });
  });
</script>