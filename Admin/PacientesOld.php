<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script-->



    <title>Hello, world!</title>
  </head>
  <body>
    
  <h1> Pacientes</h1>



<?php
$i=0;
echo'   <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">id</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">APaterno</th>
                    <th scope="col">AMaterno</th>
                    <th scope="col">Nacimiento</th>
                    <th scope="col">Domicilio</th>
                    <th scope="col">Fotografia</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>';
            $mysqli = new mysqli('localhost', 'hospital', 'poderosa8', 'hospital');
            $resultado = $mysqli->query("SELECT * FROM paciente");
            while ($fila = $resultado->fetch_assoc())
            {
                echo'   <tr>
                            <th scope="row">'.$i.'</th>
                            <td>'.$fila['id_paciente'].'</td>
                            <td>'.$fila['nombre'].'</td>
                            <td>'.$fila['apaterno'].'</td>
                            <td>'.$fila['amaterno'].'</td>
                            <td>'.$fila['nacimiento'].'</td>
                            <td>'.$fila['domicilio'].'</td>
                            <td>'.$fila['fotografia'].'</td>
                            <td></td>
                            
                        </tr>';
                //echo $fila['nombre'].' '.$fila['apaterno'].'<br/>';
            }
echo'           
            </tbody>
        </table>';
    //print_r($resultado);
?>


</body>
  </html>