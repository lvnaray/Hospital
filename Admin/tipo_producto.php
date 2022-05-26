<?php
    include('tipo_producto.controller.php');
    $tipos_producto= new Tipo_producto;
    $sistema = new Sistema;
    $sistema->verificarRoles('Administrador');
    $action = (isset($_GET['action']))?$_GET['action']:'read';
    include('views/header.php');
    switch($action)
    {
        case 'create':
            include('views/tipo_producto/form.php');
            break;

        case 'save':
            $tipo_producto=$_POST['tipo_producto'];
            $resultado = $tipos_producto->create($tipo_producto['tipo_producto']);
            $datos = $tipos_producto->read();
            include('views/tipo_producto/index.php');
            break;
        case 'delete':
            $id_tipo_producto=$_GET['id_tipo_producto'];
            $resultado = $tipos_producto->delete($id_tipo_producto);
            $datos = $tipos_producto->read();
            include('views/tipo_producto/index.php');
            break;
        case 'show':
            $id_tipo_producto = $_GET['id_tipo_producto'];
            $datos = $tipos_producto->readOne($id_tipo_producto);
            include('views/tipo_producto/form.php');
            break;
        case 'update': 
            $tipo_producto = $_POST['tipo_producto'];
            $resultado = $tipos_producto->update($tipo_producto['id_tipo_producto'],$tipo_producto['tipo_producto']);
            $datos = $tipos_producto->read();
            include('views/tipo_producto/index.php');
            break;
        default:
            $datos = $tipos_producto->read();
            include('views/tipo_producto/index.php');
            break;
    }
    include('views/footer.php');
?>