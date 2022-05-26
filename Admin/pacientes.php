<?php
    include('pacientes.controller.php');
    include('consulta.controller.php');
    $sistema = new Sistema;
    $sistema->verificarRoles('Doctor');
    $pacientes = new Paciente;
    $consulta = new Consulta;
    $action = (isset($_GET['action']))?$_GET['action']:'read';
    include('views/header.php');
    switch($action)
    {
        case 'create':
            include('views/pacientes/form.php');
            break;

        case 'save':
            $paciente=$_POST['paciente'];
            $resultado = $pacientes->create($paciente['nombre'],$paciente['apaterno'], $paciente['amaterno'], $paciente['nacimiento'], $paciente['domicilio'],$paciente['correo']);
            $datos = $pacientes->read();
            include('views/pacientes/index.php');
            break;
        case 'delete':
            $id_paciente = $_GET['id_paciente'];
            $resultado = $pacientes->delete($id_paciente);
            $datos = $pacientes->read();
            include('views/pacientes/index.php');
            break;
        case 'show':
            $id_paciente = $_GET['id_paciente'];
            $datos = $pacientes->readOne($id_paciente);
            include('views/pacientes/form.php');
            break;
        case 'update': 
            $paciente = $_POST['paciente'];
            $resultado = $pacientes->update($paciente['id_paciente'],$paciente['nombre'],$paciente['apaterno'],$paciente['amaterno'],$paciente['nacimiento'],$paciente['domicilio'],$paciente['correo']);
            $datos = $pacientes->read();
            include('views/pacientes/index.php');
            break;
        case 'my':
            $datos = $pacientes ->read(true);
            include('views/pacientes/index.php');
            break;
        case 'consulta':
            $id_paciente = $_GET['id_paciente'];
            $datos = $pacientes->readOne($id_paciente);
            $consultas = $consulta->read($id_paciente);
            //print_r($consultas);
            include('views/pacientes/consulta.php');
            break;
        case 'consulta_nueva':
            $consult =$_POST['consulta'];
            $resultado = $consulta->create($consult['id_paciente'],$consult['padecimiento'],$consult['tratamiento']);
            $id_paciente= $consult['id_paciente'];
            $datos = $pacientes->readOne($id_paciente);
            $consultas = $consulta->read($id_paciente);
            include('views/pacientes/consulta.php');
            break;
            case 'receta':
                include('consulta.report.php');
                break;
            case 'insertar':
                $data = file_get_contents("../JSON/pacientes.json");
                $datos = $pacientes->insert($data);
                break;
            case 'exportar':
                $id_paciente = $_GET['id_paciente'];
                $paciente = $pacientes->exportarOne($id_paciente);
                $data = json_encode($paciente[0]);
                header('Content-Type: application/json');
                echo $data;
                //$file ='../json/'.$paciente[0]['nombre'].'.json';
                //file_put_contents($file,$data);
                break;
        default:
            $datos = $pacientes->read();
            include('views/pacientes/index.php');
            break;
    }
    include('views/footer.php');
?>