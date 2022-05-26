<?php
    include('../Admin/sistema.controller.php');
    $sistema = new Sistema();
    $action = (isset($_GET['action']))?$_GET['action']:'read';
    include('views/header.php');
    $mensaje='';
    switch($action)
    {  
        case 'logout':
            unset($_SESSION);
            session_destroy();
            $mensaje= 'Ha salido del sistema.';
            include('views/login.php');

            break;

        case 'forget':
            $mensaje= 'Ha salido del sistema.';
            include('views/forget_pass.php');
            break;
        case 'sendPass':
            $correo= $_POST['correo'];
            if($sistema->ValidateEmail($correo)){
                $sistema->changePass($correo);
                
            }
            break;
        case 'changePass':
            $correo = $_GET['correo'];
            $token= $_GET['token'];
            if($sistema->validateToken($correo,$token)){
                include('../Login/views/changePass.php');
            }else{
                header('Location: http://www.gmail.com');
            }
            break;
        case 'savePass':
            $correo = $_POST['correo'];
            $token = $_POST['token'];
            $contrasena = $_POST['contrasena'];
            if($sistema->resetPassword($correo,$token,$contrasena)){
                echo 'La contraseña ha sido modificada correctamente';
                include('../Login/views/login.php');   
            }else{
                echo 'Ha ocurrido un error';
                include('../Login/views/login.php');

            }

            break;
        case 'validate':
            if(isset($_POST['enviar'])){
                $correo = $_POST['correo'];
                $contrasena= $_POST['contrasena'];
                if($sistema->ValidateEmail($correo)){
                   
                    if($sistema ->ValidateUser($correo,$contrasena)){
                        $roles= $sistema-> GetRoles($correo);
                        $permisos= $sistema-> GetPermisos($correo);
                        $id_usuario = $sistema ->getId_Usuario($correo);
                        $_SESSION['validado']=true;
                        $_SESSION['roles']=$roles;
                        $_SESSION['permisos']= $permisos;
                        $_SESSION['correo']= $correo;
                        $_SESSION['id_usuario']= $id_usuario;
                        header('Location: ../Admin/index.php');
                    }else{
                        echo 'usuario o contraseña incorrecto';
                    }
                }else{
                    echo 'no puedo continuar';
                }
            }
            break;
        default:
            include('views/login.php');
            break;
    }
    include('views/footer.php');
?>