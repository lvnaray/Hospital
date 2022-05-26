<?php
    include('permiso.controller.php');
    $sistema = new Sistema;
    $sistema -> verificarRoles('Administrador');
    $permisos = new Permiso;
    $action = (isset($_GET['action']))?$_GET['action']:'read';
    include('views/header.php');
    switch($action)
    {
        case 'create':
            include('views/permiso/form.php');
            break;
        case 'save':
            $permiso=$_POST['permiso'];
            $resultado=$permisos->create($permiso['permiso']);
            $datos = $permisos->read();
            include('views/permiso/index.php');
            break;
        case 'delete':
            $id_permiso=$_GET['id_permiso'];
            $resultado=$permisos->delete($id_permiso);
            $datos = $permisos->read();
            include('views/permiso/index.php');
            break;
        case 'show':
            $id_permiso=$_GET['id_permiso'];
            $datos=$permisos->readOne($id_permiso);
            include('views/permiso/form.php');
            break;
        case 'update':
            $permiso=$_POST['permiso'];
            $resultado=$permisos->update($permiso['id_permiso'],$permiso['permiso']);
            $datos = $permisos->read();
            include('views/permiso/index.php');
            break;
        default:
            $datos = $permisos->read();
            include('views/permiso/index.php');
    }
    include('views/footer.php');
?>