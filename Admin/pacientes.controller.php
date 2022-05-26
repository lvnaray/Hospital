<?php
    require_once('sistema.controller.php');


    /*
    Clase principal para pacientes
    */
     class Paciente extends Sistema{
            var $id_paciente;
            var $nombre;
            var $apaterno;
            var $amaterno;
            var $nacimiento;
            var $domicilio;
            var $fotografia;

        function setId_paciente($id){
            $this-> id_paciente = $id;

        }
        function getId_paciente(){
            return $this->id_paciente;
        }
        function setNombre($nom){
            $this-> nombre = $nom;
        }
        function getNombre(){
            return $this->nombre;
        }
        function setApaterno($apaterno){
            $this-> apaterno = $apaterno;
        }
        function getApaterno(){
            return $this->apaterno;
        }
        function setAmaterno($amaterno){
            $this-> amaterno = $amaterno;
        }
        function getAmaterno(){
            return $this->amaterno;
        }
        function setDomicilio($domicilio){
            $this-> domicilio = $domicilio;
        }
        function getDomicilio(){
            return $this->domicilio;
        }

        function setNacimiento($nacimiento){
            $this-> nacimiento = $nacimiento;
        }
        function getNacimiento(){
            return $this->nacimiento;
        }

        function setFotografia($fotografia){
            $this-> fotografia = $fotografia;
        }
        function getFotografia(){
            return $this->fotografia;
        }
        /*
        Este metodo nos sirve para crear un paciente 
        Parámetros String @nombre recibe el nombre del paciente
                String @apaterno recibe el apellido paterno del paciente
                String @amaterno recibe el apellido materno del paciente
                String @nacimiento recibe la fecha de nacimiento del pacinte
                String @domicilio recibe la direccion donde vive el paciente
        Returns integer de los registros afectados           
                
        */
        
        function create($nombre, $apaterno, $amaterno, $nacimiento, $domicilio,$correo){
            $dbh = $this->Connect();
            $dbh-> beginTransaction();
            try{
            $foto = $this->guardarFotografia();
            $sentencia ="INSERT INTO usuario(correo,contrasena) VALUES(:correo,:contrasena)";
            $stmt = $dbh->prepare($sentencia);
            $stmt -> bindParam(':correo',$correo, PDO::PARAM_STR);
            $contrasena = md5(rand(1,100));
            $stmt -> bindParam(':contrasena',$contrasena, PDO::PARAM_STR);
            $stmt -> execute();

            $sentencia = "SELECT * FROM usuario WHERE correo = :correo";
            $stmt = $dbh->prepare($sentencia);
            $stmt -> bindParam(':correo',$correo, PDO::PARAM_STR);
            $stmt -> execute();
            $rows = $stmt -> fetchAll();

            $id_usuario = $rows[0]['id_usuario'];
            
            if(is_numeric($id_usuario)){
                $sentencia = "INSERT INTO usuario_rol(id_usuario,id_rol) VALUE(:id_usuario, 2)";
                $stmt= $dbh -> prepare($sentencia);
                $stmt-> bindParam(':id_usuario',$id_usuario, PDO::PARAM_INT);
                $stmt -> execute(); 
                $id_doctor = $this -> getIdDoctor($_SESSION['id_usuario']);
                //print_r($id_doctor);
                if($foto)
            {
                $sentencia = "INSERT INTO PACIENTE(nombre,apaterno,amaterno,nacimiento,domicilio,fotografia,id_usuario,id_doctor) 
                VALUES (:nombre,:apaterno,:amaterno,:nacimiento,:domicilio,:fotografia,:id_usuario,:id_doctor)";
                $stmt = $dbh->prepare($sentencia);
                $stmt->bindParam(':fotografia',$foto,PDO::PARAM_STR);
            }else
            {
                $sentencia = "INSERT INTO PACIENTE(nombre,apaterno,amaterno,nacimiento,domicilio,id_usuario,id_doctor) 
                VALUES (:nombre,:apaterno,:amaterno,:nacimiento,:domicilio,:id_usuario,:id_doctor)";
                $stmt = $dbh->prepare($sentencia);
            }
            $stmt->bindParam(':nombre',$nombre, PDO::PARAM_STR);
            $stmt->bindParam(':apaterno',$apaterno, PDO::PARAM_STR);
            $stmt->bindParam(':amaterno',$amaterno, PDO::PARAM_STR);
            $stmt->bindParam(':nacimiento',$nacimiento, PDO::PARAM_STR);
            $stmt->bindParam(':domicilio',$domicilio, PDO::PARAM_STR);
            $stmt->bindParam(':id_usuario',$id_usuario, PDO::PARAM_INT);
            $stmt->bindParam(':id_doctor',$id_doctor, PDO::PARAM_INT);
            $resultado = $stmt->execute();
            $dbh->commit();
            return $resultado;
                }
            }
            catch(Exception $e){
                echo 'Excepcion capturada: ', $e->getMessage(), "\n";
                $dbh -> rollBack();  
            }
                $dbh -> rollBack();
            }
            
        function guardarFotografia()
        {
            $archivo= $_FILES['fotografia'];
            $tipos = array('image/jpge','image/png','image/gif');
            if($archivo['error']==0)
            {
                if(in_array($archivo['type'],$tipos))
                {
                    if($archivo['size']<=2097152)
                    {
                        $a= explode('/',$archivo['type']);
                        $nuevoNombre = md5(time()).'.'.$a[1];
                        if(move_uploaded_file($archivo['tmp_name'],'archivos/'.$nuevoNombre))
                        {
                        return $nuevoNombre;
                        }
                    }
                }
            }
            return false;
        }
        /*
        Este metodo nos sirve para poder obtener los pacientes
        Returns Array
        
        */
        function read($my = false){ 
            $dbh = $this->Connect();
            if($my){
                $id_doctor = $this -> getIdDoctor($_SESSION['id_usuario']);
                print_r($id_doctor);
                $sentencia = 'SELECT * FROM paciente p where id_doctor=:id_doctor';
                $stmt = $dbh ->prepare($sentencia);
                $stmt -> bindValue(':id_doctor',$id_doctor,PDO::PARAM_INT);
            }else{
                
                $sentencia ='SELECT * FROM paciente';
                $stmt = $dbh->prepare($sentencia);
            }
            $stmt->execute();
            $rows = $stmt->fetchAll();
            return $rows;

        }
        /*
        Este metodo nos sirve para poder obtener uno solo paciente
        params int @id_paciente ID del paciente
        Returns Array
        
        */
        function readOne($id_paciente){
            $dbh = $this->Connect();
            $this->setId_paciente($id_paciente);
            $sentencia = "SELECT * FROM paciente where id_paciente= :id_paciente";
            $stmt = $dbh->prepare($sentencia);
            $stmt->bindParam(':id_paciente',$id_paciente, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            $rows[0]['edad']= $this ->calculaEdad($rows[0]['nacimiento']);
            return $rows;
        }
        /*
        Metodo para actualizar pacientes
        Params int @id_paciente
                String @nombre recibe el nombre del paciente
                String @apaterno recibe el apellido paterno del paciente
                String @amaterno recibe el apellido materno del paciente
                String @nacimiento recibe la fecha de nacimiento del pacinte
                String @domicilio recibe la direccion donde vive el paciente
        Returns  integer       
        */
        function update($id_paciente, $nombre, $apaterno, $amaterno, $nacimiento, $domicilio){
            $dbh = $this->Connect();
            $foto = $this->guardarFotografia();
            if($foto)
            {
                $sentencia="UPDATE paciente 
                            SET nombre=:nombre,
                                apaterno=:apaterno,
                                amaterno=:amaterno,
                                nacimiento=:nacimiento,
                                domicilio=:domicilio,
                                fotografia=:fotografia 
                            where id_paciente=:id_paciente";
            $stmt = $dbh->prepare($sentencia);
            $stmt->bindParam(':fotografia',$foto, PDO::PARAM_STR);

            }
            else{
            $sentencia="UPDATE paciente 
                            SET nombre=:nombre,
                                apaterno=:apaterno,
                                amaterno=:amaterno,
                                nacimiento=:nacimiento,
                                domicilio=:domicilio 
                            where id_paciente=:id_paciente";
            $stmt = $dbh->prepare($sentencia);
            }
            $stmt->bindParam(':id_paciente',$id_paciente, PDO::PARAM_STR);
            $stmt->bindParam(':nombre',$nombre, PDO::PARAM_STR);
            $stmt->bindParam(':apaterno',$apaterno, PDO::PARAM_STR);
            $stmt->bindParam(':amaterno',$amaterno, PDO::PARAM_STR);
            $stmt->bindParam(':nacimiento',$nacimiento, PDO::PARAM_STR);
            $stmt->bindParam(':domicilio',$domicilio, PDO::PARAM_STR);
            $resultado = $stmt->execute();
            return $resultado;
            
        }
        /*
        Metodo para poder eliminar un paciente
        Params int @id_paciente id de paciente
        Returns integer
        */
            function delete($id_paciente){
                $dbh=$this->Connect();
                $sentencia = "delete FROM paciente where id_paciente=:id_paciente";
                $stmt = $dbh->prepare($sentencia);
                $stmt->bindParam(':id_paciente',$id_paciente, PDO::PARAM_STR);
                $resultado = $stmt->execute();
                return $resultado;
            }

            /*
            Este metodo nos sirve para crear un paciente JSON
            Parámetros String @nombre recibe el nombre del paciente
                    String @apaterno recibe el apellido paterno del paciente
                    String @amaterno recibe el apellido materno del paciente
                    String @nacimiento recibe la fecha de nacimiento del pacinte
                    String @domicilio recibe la direccion donde vive el paciente
            Returns integer de los registros afectados           
                    
            */
            function insert($data){
            $paciente = json_decode($data, true);
            
            $dbh=$this->Connect();
            $dbh-> beginTransaction();
            $info = array();
            try{
                $sentencia ="INSERT INTO usuario(correo,contrasena) VALUES(:correo,:contrasena)";
                $contrasena= md5($paciente['contrasena']);
                $stmt = $dbh->prepare($sentencia);
                $stmt -> bindParam(':correo',$paciente['correo'], PDO::PARAM_STR);
                $stmt -> bindParam(':contrasena',$contrasena, PDO::PARAM_STR);
                $resultado= $stmt -> execute();

                $sentencia = "SELECT * FROM usuario WHERE correo = :correo";
                $stmt = $dbh->prepare($sentencia);
                $stmt -> bindParam(':correo',$paciente['correo'], PDO::PARAM_STR);
                $stmt -> execute();
                $rows = $stmt -> fetchAll();
                $id_usuario = $rows[0]['id_usuario'];

            if(is_numeric($id_usuario)){
                $sentencia = "INSERT INTO usuario_rol(id_usuario,id_rol) VALUE(:id_usuario, 2)";
                $stmt= $dbh -> prepare($sentencia);
                $stmt-> bindParam(':id_usuario',$id_usuario, PDO::PARAM_INT);
                $resultado= $stmt -> execute(); 
            
                $sentencia = "INSERT INTO PACIENTE(nombre,apaterno,amaterno,nacimiento,domicilio,id_usuario,id_doctor) 
                VALUES (:nombre,:apaterno,:amaterno,:nacimiento,:domicilio,:id_usuario,:id_doctor)";
                $stmt = $dbh->prepare($sentencia);
                $stmt->bindParam(':nombre',$paciente['nombre'], PDO::PARAM_STR);
                $stmt->bindParam(':apaterno',$paciente['apaterno'], PDO::PARAM_STR);
                $stmt->bindParam(':amaterno',$paciente['amaterno'], PDO::PARAM_STR);
                $stmt->bindParam(':nacimiento',$paciente['nacimiento'], PDO::PARAM_STR);
                $stmt->bindParam(':domicilio',$paciente['domicilio'], PDO::PARAM_STR);
                $stmt->bindParam(':id_usuario',$id_usuario, PDO::PARAM_INT);
                $stmt->bindParam(':id_doctor',$paciente['id_doctor'], PDO::PARAM_INT);
                $resultado=$stmt -> execute();

                $id_doctor = $paciente['id_doctor'];
            
                if($resultado){
                    $sentencia = "SELECT * FROM paciente WHERE id_usuario = :id_usuario";
                    $stmt = $dbh->prepare($sentencia);
                    $stmt -> bindParam(':id_usuario',$id_usuario, PDO::PARAM_STR);
                    $stmt -> execute();
                    $rows = $stmt -> fetchAll();
                    $id_paciente = $rows[0]['id_paciente'];
                    
                    foreach($paciente['consultas'] as $key=> $consulta){
                        $sentencia = "INSERT INTO consulta(id_paciente, id_doctor,padecimiento, tratamiento, fecha)
                        values(:id_paciente, :id_doctor,:padecimiento, :tratamiento, :fecha)";
                        $stmt= $dbh -> prepare($sentencia);
                        $stmt->bindParam(':id_paciente',$id_paciente, PDO::PARAM_INT);
                        $stmt->bindParam(':id_doctor',$id_doctor, PDO::PARAM_INT);
                        $stmt->bindParam(':padecimiento',$consulta['padecimiento'], PDO::PARAM_STR);
                        $stmt->bindParam(':tratamiento',$consulta['tratamiento'], PDO::PARAM_STR);
                        $stmt->bindParam(':fecha',$consulta['fecha'], PDO::PARAM_STR);
                        $resultado=$stmt -> execute();
                        
                    }
                }
                $dbh->commit();
                    
                    $info['status']=200;
                    $info['message']='Paciente dado de alta';
                    $this->printJSON($info);
                
                }
            }
            catch(Exception $e){
                echo 'Excepcion capturada: ', $e->getMessage(), "\n";
                $dbh -> rollBack();
                $info['status']=403;
                $info['message']='Error al dar de alta el paciente';
                $this->printJSON($info);  
            }
                $dbh -> rollBack();
                $info['status']=403;
                $info['message']='Error al dar de alta el paciente';
                $this->printJSON($info);
            }

                /*
            Este metodo nos sirve para poder obtener uno solo paciente por JSON
            params int @id_paciente ID del paciente
            Returns Array
            
            */
            function exportarOne($id_paciente) {

                $dbh = $this->connect();
                $sentencia = "SELECT u.correo, u.contrasena, p.nombre, p.apaterno, p.amaterno, p.nacimiento, p.domicilio
                            FROM paciente p JOIN usuario u ON u.id_usuario = p.id_usuario 
                            WHERE p.id_paciente = :id_paciente";
                $stmt = $dbh->prepare($sentencia);
                $stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
                $stmt->execute();
                
                $resultado = array();
                foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $key => $paciente) {
                    array_push($resultado, $paciente);
                }

                $dbh = $this->connect();
                $sentencia = "SELECT padecimiento, tratamiento, fecha FROM consulta WHERE id_paciente = :id_paciente";
                $stmt = $dbh->prepare($sentencia);
                $stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
                $stmt->execute();

                $resultado[0]['consultas'] = array();
                foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $key => $consulta) {
                    array_push($resultado[0]['consultas'], $consulta);
                }

                $this->printJSON($resultado);
            }
            /*
            Este metodo nos sirve para poder obtener los pacientes
            Returns Array
            
            */   
            function exportar() {

                $dbh = $this->connect();
                $sentencia = "SELECT p.id_paciente, u.correo, p.nombre, p.apaterno, p.amaterno, p.nacimiento, p.domicilio
                            FROM paciente p JOIN usuario u ON u.id_usuario = p.id_usuario ORDER BY apaterno, amaterno, nombre";
                $stmt = $dbh->prepare($sentencia);
                $stmt->execute();
                
                $resultado = array();
                foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $key => $paciente) {
                    array_push($resultado, $paciente);
                }

                $this->printJSON($resultado);
            }

            function deleteJson($id_paciente){
                $dbh = $this->connect();

                try{
                    $dbh-> beginTransaction();
                
                $sentencia = "delete from consulta where id_paciente=:id_paciente";
                $stmt = $dbh->prepare($sentencia);
                $stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
                $stmt->execute();

                $sentencia = "select id_usuario from paciente where id_paciente=:id_paciente";
                $stmt = $dbh->prepare($sentencia);
                $stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
                $stmt->execute();
                $id_usuario= $stmt->fetchAll()[0];

                $sentencia = "delete from usuario_rol where id_usuario=:id_usuario";
                $stmt = $dbh->prepare($sentencia);
                $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
                $stmt->execute();

                $sentencia = "delete from paciente where id_paciente=:id_paciente";
                $stmt = $dbh->prepare($sentencia);
                $stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
                $stmt->execute();

                $dbh->commit();
                $info['status']=200;
                $info['message']='Paciente borrado';
                $this->printJSON($info);

                }
                catch(Exception $e){
                    echo 'Excepcion capturada: ', $e->getMessage(), "\n";
                    $dbh -> rollBack();
                    $info['status']=403;
                    $info['message']='Error al borrar paciente';
                    $this->printJSON($info);  
                }
                    $dbh -> rollBack();
                    $info['status']=403;
                    $info['message']='Error al borrar paciente';
                    $this->printJSON($info);


            }
            
            /*
            Metodo para actualizar pacientes por JSON
            Params int @id_paciente
                    String @nombre recibe el nombre del paciente
                    String @apaterno recibe el apellido paterno del paciente
                    String @amaterno recibe el apellido materno del paciente
                    String @nacimiento recibe la fecha de nacimiento del pacinte
                    String @domicilio recibe la direccion donde vive el paciente
            Returns  integer       
            */
            function updateJson($data,$id_paciente)
            {
                $dbh=$this->connect();
                $info=array();
                try
                {
                    $paciente = json_decode($data, true);
                    $dbh->beginTransaction();

                    $sentencia="UPDATE paciente 
                            SET nombre=:nombre,
                                apaterno=:apaterno,
                                amaterno=:amaterno,
                                nacimiento=:nacimiento,
                                domicilio=:domicilio 
                            where id_paciente=:id_paciente";
                    $stmt = $dbh->prepare($sentencia);
                    $stmt->bindParam(':nombre', $paciente['nombre'], PDO::PARAM_STR);
                    $stmt->bindParam(':apaterno', $paciente['apaterno'], PDO::PARAM_STR);
                    $stmt->bindParam(':amaterno', $paciente['amaterno'], PDO::PARAM_STR);
                    $stmt->bindParam(':nacimiento', $paciente['nacimiento'], PDO::PARAM_STR);
                    $stmt->bindParam(':domicilio', $paciente['domicilio'], PDO::PARAM_STR);
                    $stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
                    $stmt->execute();
                    if(isset($paciente['consultas']))
                    {
                        foreach ($paciente['consultas'] as $key => $consulta)
                        {
                            $sentencia = "insert into consulta(id_paciente, id_doctor, fecha, padecimiento, tratamiento) values(:paciente,:doctor,:fecha,:padecimiento,:tratamiento)";
                            $stmt = $dbh->prepare($sentencia);
                            $stmt->bindParam(':paciente', $id_paciente, PDO::PARAM_INT);
                            $stmt->bindParam(':doctor', $consulta['id_doctor'], PDO::PARAM_INT);
                            $stmt->bindParam(':padecimiento', $consulta['padecimiento'], PDO::PARAM_STR);
                            $stmt->bindParam(':tratamiento', $consulta['tratamiento'], PDO::PARAM_STR);
                            $stmt->bindParam(':fecha', $consulta['fecha'], PDO::PARAM_STR);
                            $stmt->execute();
                        }
                    }
                    $dbh->commit();
                    $info['status']=200;
                    $info['message']='Paciente Actualizado';
                    $this->printJSON($info);
                }
                catch(Exception $sauf)
                {
                    echo("Cancelado");
                    $dbh->rollBack();
                    $info['status']=403;
                    $info['message']='Error al actualizar';
                    $this->printJSON($info);
                }
                $dbh->rollBack();
                $info['status']=403;
                $info['message']='Error al actualizar';
                $this->printJSON($info);
            }

    }
?>