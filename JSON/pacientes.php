<?php
//$data = file_get_contents("pacientes.json");
//$paciente = json_decode($data, true);
//print_r($paciente);
$apacientes = array("nombre"=>'Luis',
                        "apaterno"=>'Lopez',
                            "consultas"=>array(0=>array("padecimiento"=>"Dolor de rodilla",
                            "tratamiento"=>'Aspirina'),
                            1=>array("padecimiento"=>"Dolor de cabeza",
                            "tratamiento"=>'paracetamol'
)));

$data = json_encode($apacientes);

header('Content-Type: application/json');
echo ($data);
?>