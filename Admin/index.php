<?php
include('sistema.controller.php');
    
    $sistema= new Sistema;
    $sistema -> verificarSesion();
    include('views/header.php');
?>

<h1>Bienvenido al sistema</h1>

<?php 
    include('views/footer.php');
?>