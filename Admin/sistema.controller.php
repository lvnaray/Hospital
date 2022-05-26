<?php
        session_start();
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        require_once('../Admin/init.php');
        require_once '../vendor/autoload.php';
        class Sistema{
            var $dsn= 'mysql:host=localhost;dbname=hospital';
            var $user = 'hospital';
            var $pass= 'poderosa8';

            function Connect(){
                $dbh = new PDO($this->dsn,$this->user,$this->pass);
                return $dbh;
            }

            function validateUser($correo, $contrasena)
            {
                $contrasena=md5($contrasena);
                $dbh= $this-> connect();
                $query = "SELECT * FROM usuario where correo = :correo and contrasena = :contrasena";
                $stmt = $dbh->prepare($query);
                $stmt->bindParam(':correo',$correo, PDO::PARAM_STR);
                $stmt->bindParam(':contrasena',$contrasena, PDO::PARAM_STR);
                $stmt->execute();
                $rows = $stmt->fetchAll();
               return isset($rows[0]['correo'])? true: false;
            }

            function validateToken($correo, $token)
            {
                $dbh= $this-> connect();
                if(!is_null($token)){
                $query = "SELECT * FROM usuario where correo = :correo and token = :token";
                $stmt = $dbh->prepare($query);
                $stmt->bindParam(':correo',$correo, PDO::PARAM_STR);
                $stmt->bindParam(':token',$token, PDO::PARAM_STR);
                $stmt->execute();
                $rows = $stmt->fetchAll();
               return isset($rows[0]['correo'])? true: false;
                }
                
            }
            function resetPassword($correo,$token,$contrasena){
                if($this->ValidateEmail($correo)){
                    if($this ->validateToken($correo,$token)){
                        $dbh= $this-> connect();
                        if(!is_null($token)){
                            $contrasena= md5($contrasena);
                            $query = "UPDATE usuario SET contrasena =:contrasena, token =null WHERE correo=:correo";
                            $stmt = $dbh->prepare($query);
                            $stmt->bindParam(':correo',$correo, PDO::PARAM_STR);
                            $stmt->bindParam(':contrasena',$contrasena, PDO::PARAM_STR);
                            $rows=$stmt->execute();
                            if($rows){
                                return true;
                            }
                            return false;
                           return isset($rows[0]['correo'])? true: false;
                            }

                    }
                }
                return false;

            }
            
            
            function ValidateEmail($correo){
                return (false !== filter_var($correo, FILTER_VALIDATE_EMAIL));
            }
            function GetRoles($correo){
                $dbh= $this-> connect();
                $query = "SELECT r.id_rol,r.rol FROM usuario u 
                join usuario_rol ur on u.id_usuario = ur.id_usuario 
                join rol r on ur.id_rol = r.id_rol where u.correo=:correo";
                $stmt = $dbh->prepare($query);
                $stmt->bindParam(':correo',$correo, PDO::PARAM_STR);
                $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $roles = array();
                foreach($rows as $key =>$value):
                    array_push($roles,$value['rol']);
                endforeach;
                return $roles;
            }
            function GetPermisos($correo){
                $dbh= $this-> connect();
                $query = "SELECT p.id_permiso, p.permiso FROM usuario u 
                join usuario_rol ur on u.id_usuario = ur.id_usuario 
                join rol r on ur.id_rol = r.id_rol 
                join rol_permiso rp on r.id_rol= rp.id_rol 
                join permiso p on rp.id_permiso =p.id_permiso
                where u.correo=:correo";
                $stmt = $dbh->prepare($query);
                $stmt->bindParam(':correo',$correo, PDO::PARAM_STR);
                $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $permisos = array();
                foreach($rows as $key =>$value):
                    array_push($permisos,$value['permiso']);
                endforeach;
                return $permisos;
                

            }
            function verificarRoles($rol)
            {
                $this->verificarSesion();
                $roles = $_SESSION['roles'];
                if(!in_array($rol,$roles)){
                echo 'Rol no adecuado';
                include('../login/views/header.php');
                include('../login/views/login.php');
                include('../login/views/footer.php');
                die();
                
                }

            }

            function validarRoles($rol){
                $this->verificarSesion();
                $roles = $_SESSION['roles'];
                if(in_array($rol,$roles)){
                return true;
            }
            return false; 
            }

            function validarPermiso($permiso){
                $this->verificarSesion();
                $permisos = $_SESSION['permisos'];
                if(in_array($permiso,$permisos)){
                return true;
            }
            return false;
        }

        function verificarSesion(){
            if(!isset($_SESSION['validado'])){
                echo "Es necesario inicar sesion";
                include('../login/views/header.php');
                include('../login/views/login.php');
                include('../login/views/footer.php');
                die();
            }
        }

        function getIdDoctor($id_usuario){
            $dbh = $this ->Connect();
            $sentencia = "SELECT id_doctor FROM doctor WHERE id_usuario= :id_usuario";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindParam(':id_usuario',$id_usuario,PDO::PARAM_INT);
            $stmt -> execute();
            $dato = $stmt -> fetchAll();
            return $dato[0]['id_doctor'];
        }
        function getId_Usuario($correo){
            $dbh = $this ->Connect();
            $sentencia = "SELECT id_usuario FROM usuario WHERE correo= :correo";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindParam(':correo',$correo,PDO::PARAM_STR);
            $stmt -> execute();
            $dato = $stmt -> fetchAll();
            if(isset($dato[0]['id_usuario'])){
                return $dato[0]['id_usuario'];
            }else{
                return null;
            }
        }

        function changePass($correo){
            $id_usuario=$this->getId_Usuario($correo);
            if(!is_null($id_usuario)){

                $token= substr(crypt(sha1(hash('sha512',md5(rand(1,9999)).$id_usuario)),'cruz azul campeon'),1,10);
                $dbh = $this ->Connect();
                $sentencia = "UPDATE usuario SET token = :token WHERE id_usuario= :id_usuario";
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindParam(':token',$token,PDO::PARAM_STR);
                $stmt -> bindParam(':id_usuario',$id_usuario,PDO::PARAM_INT);
                $stmt -> execute();
                echo 'un correo llegará a su correo electronico';

                require '/xampp/htdocs/hospital/vendor/autoload.php';
                $mail = new PHPMailer();
                $mail->isSMTP();
                $mail->SMTPDebug = SMTP::DEBUG_OFF;
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 587;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->SMTPAuth = true;
                $mail->Username = '18031084@itcelaya.edu.mx';
                $mail->Password = PASSGMAIL;
                $mail->setFrom('18031084@itcelaya.edu.mx', 'LUIS DAVID LUNA LUNA');
                $mail->addReplyTo('18031084@itcelaya.edu.mx', 'LUIS DAVID LUNA LUNA');
                $mail->addAddress($correo,$correo);
                $mail->Subject = 'Recuperacion de contraseña de hospital san lao';
                $cuerpo= "Estimado usuario por favor presione la siguiente liga para cambiar de contraseña:<br><a href='http://localhost/hospital/login/login.php?action=changePass&correo=".$correo."&token=".$token."'>Recuperar Correo</a>";
                $mail->msgHTML($cuerpo);
                $mail->AltBody = 'Mensaje alternativo';
                if (!$mail->send()) {
                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                } else {
                    echo 'Message sent!';
                }

            }
        }
        function calculaedad($fechanacimiento){
            list($ano,$mes,$dia) = explode("-",$fechanacimiento);
            $ano_diferencia  = date("Y") - $ano;
            $mes_diferencia = date("m") - $mes;
            $dia_diferencia   = date("d") - $dia;
            if ($dia_diferencia < 0 || $mes_diferencia < 0)
              $ano_diferencia--;
            return $ano_diferencia;
          }

          function printJSON($info){
            $info= json_encode($info,true);
            echo $info;
            header('Content-Type: application/json');
            die();


          }

    }
    
    /*
    $sistema = new Sistema();
    $resultado= $sistema ->validateUser('luislao@itcelaya.edu.mx','123');
    print_r($resultado);
    */
?>