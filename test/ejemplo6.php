<?php
$datos[0]['nombre']= "Luis";
$datos[1]['nombre']= "Ponce";
$datos[2]['nombre']= "Uribe";
$datos[3]['nombre']= "Fátima";
$datos['total']= count($datos);
$datos['nombre']= "calificaciones";
echo $datos['nombre'];
foreach($datos as $key => $value){
    if(is_numeric($key)){
        echo "<br />".$value['nombre'];
    }
}
echo "<br />".$datos['total'];
?>