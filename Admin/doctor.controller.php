<?php
    require_once("sistema.controller.php");
    class Doctor extends Sistema {
        var $id_doctor;
        var $nombre;
        var $apaterno;
        var $amaterno;
        var $especialidad;
        var $id_usuario;

         /*
         * Metodo para crear un doctor
         * params:  String  @nombre: recibira el nombre del doctor
         *          String  @apaterno: recibira el apellido paterno del doctor
         *          String  @amaterno: recibira el apellido materno del doctor
         *          string  @especialidad: Recibira la especialidad del doctor
         *          String  @correo: Recibira el correo del doctor
         *          String  @contrasena: Recibira la contraseña del doctor
         * returns integer
         */
        function create($nombre, $apaterno, $amaterno, $especialidad, $correo, $contrasena)
        {
            $dbh = $this -> Connect();
            $dbh -> beginTransaction();
            try{
                $query = "INSERT INTO usuario(correo, contrasena) VALUES(:correo, :contrasena)";
                $stmt = $dbh -> prepare($query);
                $stmt -> bindParam(":correo", $correo, PDO::PARAM_STR);
                $contrasena = md5($contrasena);
                $stmt -> bindParam(":contrasena", $contrasena, PDO::PARAM_STR);
                $stmt -> execute();
                $sentencia = "SELECT * FROM usuario WHERE correo = :correo";
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindParam(":correo", $correo, PDO::PARAM_STR);
                $stmt -> execute();
                $fila = $stmt -> fetchAll();
                $id_usuario = $fila[0]['id_usuario'];
                if(is_numeric($id_usuario)){
                    $sentencia = "INSERT INTO usuario_rol(id_usuario, id_rol) VALUES(:id_usuario, 2)";
                    $stmt = $dbh -> prepare($sentencia);
                    $stmt -> bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
                    $stmt -> execute();
                    $sentencia = "INSERT INTO doctor(nombre, apaterno, amaterno, especialidad, id_usuario)
                                                VALUES(:nombre, :apaterno, :amaterno, :especialidad, :id_usuario)";
                    $stmt = $dbh -> prepare($sentencia);
                    $stmt -> bindParam(":nombre", $nombre, PDO::PARAM_STR);
                    $stmt -> bindParam(":apaterno", $apaterno, PDO::PARAM_STR);
                    $stmt -> bindParam(":amaterno", $amaterno, PDO::PARAM_STR);
                    $stmt -> bindParam(":especialidad", $especialidad, PDO::PARAM_STR);
                    $stmt -> bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
                    $stmt -> execute();
                    $dbh -> commit();
                    return $stmt;
                }
            }
            catch(Exception $e){
                echo 'Excepción capturada: ',  $e->getMessage(), "\n";
            }
            $dbh -> rollBack();
            return false;
        }

        /*
         * Metodo para leer todos los doctores
         * returns array
         */
        function read(){
            $dbh = $this -> Connect();
            $busqueda = (isset($_GET['busqueda']))?"%".$_GET['busqueda']."%":'';
            $ordenamiento = (isset($_GET['ordenamiento']))?$_GET['ordenamiento']:'u.correo';
            $limite = (isset($_GET['limite']))?$_GET['limite']:'5';
            $desde = (isset($_GET['desde']))?$_GET['desde']:'0';
            $stmt = $dbh -> prepare('SELECT * FROM doctor d WHERE CONCAT(d.nombre, " ", d.apaterno, " ", d.amaterno) LIKE :busqueda
                                         ORDER BY :ordenamiento LIMIT :limite OFFSET :desde');
            $stmt -> bindValue(":busqueda", '%' . $busqueda . '%', PDO::PARAM_STR);
            $stmt -> bindValue(":ordenamiento", $ordenamiento, PDO::PARAM_STR);
            $stmt -> bindValue(":limite", $limite, PDO::PARAM_INT);
            $stmt -> bindValue(":desde", $desde, PDO::PARAM_INT);
            $stmt -> execute();
            $rows = $stmt -> fetchAll();
            return $rows;
        }

        /*
         * Metodo para leer un doctor
         * returns array
         */
        function readOne($id_doctor){
            $dbh = $this -> Connect();
            $query = "SELECT * FROM doctor WHERE id_doctor = :id_doctor";
            $stmt = $dbh -> prepare($query);
            $stmt -> bindParam(':id_doctor', $id_doctor, PDO::PARAM_INT);
            $stmt -> execute();
            $rows = $stmt -> fetchAll();
            return $rows;
        }

        /*
         *  Metodo para eliminar doctor
         *  params: Integer@id: id del doctor
         *  returns Integer 
         */
        function delete($id_doctor){
            $dbh = $this -> Connect();
            $dbh -> beginTransaction();
            try {
                $query = "SELECT id_usuario FROM doctor WHERE id_doctor = :id_doctor";
                $stmt = $dbh -> prepare($query);
                $stmt -> bindParam(':id_doctor', $id_doctor, PDO::PARAM_INT);
                $stmt ->execute();
                $id_usuario = $stmt -> fetchAll()[0]['id_usuario'];
                print ($id_usuario);
                $query = "DELETE FROM doctor WHERE id_doctor = :id_doctor";
                $stmt = $dbh -> prepare($query);
                $stmt -> bindParam(':id_doctor', $id_doctor, PDO::PARAM_INT);
                $stmt -> execute();
                $query = "DELETE FROM usuario_rol WHERE id_usuario = :id_usuario";
                $stmt = $dbh -> prepare($query);
                $stmt -> bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
                $stmt -> execute();
                $query = "DELETE FROM usuario WHERE id_usuario = :id_usuario";
                $stmt = $dbh -> prepare($query);
                $stmt -> bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
                $stmt -> execute();
                $result = $dbh -> commit();
                return $result;
            }
            catch (Exception $e)
            {
                echo "Excepción catcheada: ".$e -> getMessage()."\n";
            }
            $dbh -> rollBack();
            return false;
        }

        /*
         * Metodo para actualizar un doctor
         * params:  int     @id_doctor: recibirá el identificador del doctor
         *          String  @nombre: recibira el nombre del doctor
         *          String  @apaterno: recibira el apellido paterno del doctor
         *          String  @amaterno: recibira el apellido materno del doctor
         *          string  @especialidad: Recibira la especialidad del doctor
         *          String  @correo: Recibira el correo del doctor
         *          String  @contrasena: Recibira la contraseña del doctor
         * returns integer
         */
        function update($id_doctor, $nombre, $apaterno, $amaterno, $especialidad){
            $dbh = $this -> Connect();
            $query = "UPDATE doctor SET nombre = :nombre, apaterno = :apaterno, amaterno = :amaterno, especialidad = :especialidad WHERE id_doctor = :id_doctor";
            $stmt = $dbh -> prepare($query);
            $stmt -> bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt -> bindParam(":apaterno", $apaterno, PDO::PARAM_STR);
            $stmt -> bindParam(":amaterno", $amaterno, PDO::PARAM_STR);
            $stmt -> bindParam(":especialidad", $especialidad, PDO::PARAM_STR);
            $stmt -> bindParam(":id_doctor", $id_doctor, PDO::PARAM_INT);
            $stmt -> execute();
            return $stmt;
        }

        function total(){
            $dbh = $this -> Connect();
            $sentencia = "SELECT COUNT(id_doctor) AS total FROM doctor";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $rows = $stmt -> fetchAll();
            return $rows[0]['total'];
        }

    }
