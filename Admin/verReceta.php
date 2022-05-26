<?php
    $id_consulta = $_GET['id_consulta'];
?>

<iframe src="http://localhost/hospital/Admin/pacientes.php?action=receta&id_consulta=<?php echo $id_consulta;?>" width="100%" height="100%" frameborder="0">
</iframe>