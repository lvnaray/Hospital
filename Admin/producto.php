<?php
    include('producto.controller.php');
    include('tipo_producto.controller.php');
    $sistema = new Sistema;
    $sistema->verificarRoles('Doctor');
    $productos = new Producto;
    $tipo_producto= new Tipo_producto;
    $action = (isset($_GET['action']))?$_GET['action']:'read';
    $tipos=$tipo_producto->read();

    include('views/header.php');
    switch($action)
    {
        case 'create':
            include('views/producto/form.php');
            break;

        case 'save':
            $producto=$_POST['producto'];
            $resultado = $productos->create($producto['producto'], $producto['precio'],$producto['id_tipo_producto']);
            $datos = $productos->read();
            include('views/producto/index.php');
            break;
        case 'delete':
            $id_producto = $_GET['id_producto'];
            $resultado = $productos->delete($id_producto);
            $datos = $productos->read();
            include('views/producto/index.php');
            break;
        case 'show':
            $id_producto = $_GET['id_producto'];
            $datos = $productos->readOne($id_producto);
            include('views/producto/form.php');
            break;
        case 'update': 
            $producto = $_POST['producto'];
            $resultado = $productos->update($producto['id_producto'],$producto['producto'],$producto['precio'],$producto['id_tipo_producto']);
            $datos = $productos->read();
            include('views/producto/index.php');
            break;
        default:
            $datos = $productos->read();
            include('views/producto/index.php');
            break;
    }
    include('views/footer.php');
?>