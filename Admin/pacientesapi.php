<?php
    include('pacientes.controller.php');
    include('consulta.controller.php');
    $sistema = new Sistema;
    //$sistema->verificarRoles('Doctor');
    $pacientes = new Paciente;
    $consulta = new Consulta;
    //$action = (isset($_GET['action']))?$_GET['action']:'read';
    $action=$_SERVER['REQUEST_METHOD'];
   
    switch($action)
    {
        case 'DELETE':
            if(isset($_GET['id_paciente']))
            {
                $id_paciente=$_GET['id_paciente'];
                $datos=$pacientes->deleteJson($id_paciente);
            }
            break;

            case 'POST':
                if(isset($_GET['id_paciente']))
                {
                    /*Update*/
                    $id_paciente=$_GET['id_paciente'];
                    //print_r($_GET);
                    $data = @file_get_contents('php://input');
                    //print_r($data);
                    $datos=$pacientes->updateJson($data,$id_paciente);
                }
                else
                {
                    /*insert*/
                    $data = @file_get_contents('php://input');
                    $resultado=$pacientes->insert($data);
                }
            break;

        case 'GET':
        default:
        if(isset($_GET['id-paciente'])){
            $id_paciente = $_GET['id_paciente'];
            $datos = $pacientes->exportarOne($id_paciente);
        }else{
            $datos =$pacientes->exportar();
        }

    
    }

?>