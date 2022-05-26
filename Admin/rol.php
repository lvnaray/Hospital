<?php
    include('rol.controller.php');
    include('permiso.controller.php');
    $sistema = new Sistema;
    $sistema -> verificarRoles('Administrador');
    $roles = new Rol;
    $permiso = new Permiso;
    $action = (isset($_GET['action']))?$_GET['action']:'read';
    include('views/header.php');
    switch($action)
    {
        case 'permiso':
            $id_rol = $_GET['id_rol'];
            $permisos = $permiso -> getPermisosRolAvailable($id_rol);
            include('views/asignar_permisos/form.php');
            break;

        case 'no_permiso':
            $id_rol = $_GET['id_rol'];
            $permisos = $permiso -> getPermisosRol($id_rol);
            include('views/asignar_permisos/form.php');
            break;

        case 'assign_permiso':
            $rol_permiso = $_POST['permiso'];
            $resultado = $permiso->assignPermiso($rol_permiso['id_rol'], $rol_permiso['id_permiso']);
            $datos = $roles->read();
            include('views/rol/index.php');
            break;

        case 'delete_permiso':
            $rol_permiso = $_POST['permiso'];
            $resultado = $permiso->deletePermiso($rol_permiso['id_rol'], $rol_permiso['id_permiso']);
            $datos = $roles->read();
            include('views/rol/index.php');
            break;

        case 'create':
            include('views/rol/form.php');
            break;
        case 'save':
            $rol=$_POST['rol'];
            $resultado=$roles->create($rol['rol']);
            $datos = $roles->read();
            include('views/rol/index.php');
            break;
        case 'delete':
            $id_rol=$_GET['id_rol'];
            $resultado=$roles->delete($id_rol);
            $datos = $roles->read();
            include('views/rol/index.php');
            break;
        case 'show':
            $id_rol=$_GET['id_rol'];
            $datos=$roles->readOne($id_rol);
            include('views/rol/form.php');
            break;
        case 'update':
            $rol=$_POST['rol'];
            $resultado=$roles->update($rol['id_rol'],$rol['rol']);
            $datos = $roles->read();
            include('views/rol/index.php');
            break;
        case 'assign_permiso':
            $rol_permiso = $_POST['permiso'];
            $resultado = $permiso -> assignPermiso($rol_permiso['id_rol'], $rol_permiso['id_permiso']);
            $datos = $roles -> read();
            include('views/rol/index.php');
            break;
        default:
            $datos = $roles->read();
            include('views/rol/index.php');
    }
    include('views/footer.php');

?>