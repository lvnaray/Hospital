<?php
    require_once('sistema.controller.php');

   /*
    * Método para insertar un registro de un rol a la base de datos Hospital
    * Params String @rol recibe el nombre del rol
    * Return Integer con la cantidad de registros afectados
    */
    class Rol extends Sistema{
        function create($rol)
        {
            $dbh = $this->connect();
            $sentencia = "INSERT INTO rol(rol) VALUES(:rol)";
            $stmt= $dbh->prepare($sentencia);
            $stmt->bindParam(':rol', $rol, PDO::PARAM_STR);
            $resultado = $stmt->execute();
            return $resultado;
        }

       /*
        * Método para obtener todos los rol
        * Return Array con todos los roles por cantidades
        */
        function read()
        {
            $dbh = $this -> Connect();
            $busqueda = (isset($_GET['busqueda']))?$_GET['busqueda']:'';
            $ordenamiento = (isset($_GET['ordenamiento']))?$_GET['ordenamiento']:'r.rol';
            $limite = (isset($_GET['limite']))?$_GET['limite']:'5';
            $desde = (isset($_GET['desde']))?$_GET['desde']:'0';
            $sentencia = 'SELECT * FROM rol r WHERE r.rol LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindValue(":busqueda", '%' . $busqueda . '%', PDO::PARAM_STR);
            $stmt -> bindValue(":ordenamiento", $ordenamiento, PDO::PARAM_STR);
            $stmt -> bindValue(":limite", $limite, PDO::PARAM_INT);
            $stmt -> bindValue(":desde", $desde, PDO::PARAM_INT);
            $stmt -> execute();
            $rows = $stmt -> fetchAll();
            return $rows;
        }

       /*
        * Método para obtener la información de un solo rol
        * Params Integer @id_rol recibe el id del rol
        * Return Array con la información del permiso
        */
        function readOne($id_rol)
        {
            $dbh = $this->connect();
            $sentencia='SELECT * FROM rol WHERE id_rol = :id_rol';
            $stmt = $dbh->prepare($sentencia);
            $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
            $stmt->execute();
            $filas=$stmt->fetchAll();
            return $filas;
        }

       /*
        * Método para actualizar un registro de un rol a la base de datos Hospital
        * Params Integer @id_rol recibe el id del rol
        * Params String  @rol recibe el nombre del rol
        * Return Integer con la cantidad de registros afectados
        */
        function update($id_rol, $rol)
        {
            $dbh = $this->connect();
            $sentencia = 'UPDATE rol SET rol = :rol WHERE id_rol = :id_rol';
            $stmt= $dbh->prepare($sentencia);
            $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
            $stmt->bindParam(':rol', $rol, PDO::PARAM_STR);
            $resultado = $stmt->execute();
            return $resultado;
        }

       /*
        * Método para eliminar un solo rol
        * Params Integer @id_rol recibe el id del rol
        * Return Integer con los registros afectados
        */
        function delete($id_rol)
        {
            $dbh = $this -> connect();
            $dbh -> beginTransaction();
            try{
                $sentencia = 'DELETE FROM rol_permiso WHERE id_rol = :id_rol';
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
                $resultado = $stmt -> execute();
                $sentencia = 'DELETE FROM usuario_rol WHERE id_rol = :id_rol';
                $stmt= $dbh -> prepare($sentencia);
                $stmt -> bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
                $resultado = $stmt -> execute();
                $sentencia = 'DELETE FROM rol WHERE id_rol = :id_rol';
                $stmt = $dbh->prepare($sentencia);
                $stmt -> bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
                $resultado = $stmt -> execute();
                $dbh -> commit();
                return $resultado;
            } catch(Exception $e){
                echo 'Excepción capturada: ',  $e -> getMessage(), "\n";
                $dbh -> rollBack();
            }
            $dbh -> rollBack();
        }

       /*
        * Método para obtener los roles de un usuario
        * Params Integer @id recibe el id del usuario
        * Return Arreglo con los roles de un usuario
        */
        function getRolesUser($id){
            $dbh = $this ->Connect();
            $query = "SELECT r.rol, r.id_rol FROM usuario u 
                            JOIN usuario_rol ur ON u.id_usuario = ur.id_usuario 
                            JOIN rol r ON ur.id_rol = r.id_rol 
                      WHERE u.id_usuario = :id_usuario";
            $stmt = $dbh ->prepare($query);
            $stmt -> bindParam(":id_usuario", $id, PDO::PARAM_INT);
            $stmt -> execute();
            $filas=$stmt->fetchAll();
            return $filas;
        }

       /*
        * Método para obtener los roles disponibles de un usuario
        * Params Integer @id recibe el id del usuario
        * Return Arreglo con los roles disponibles de un usuario
        */
        function getRolesUserAvailable($id){
            $dbh = $this ->Connect();
            $query = "SELECT id_rol, rol FROM rol 
                      WHERE id_rol NOT IN(SELECT r.id_rol FROM usuario u 
                                            JOIN usuario_rol ur ON u.id_usuario = ur.id_usuario 
                                            JOIN rol r ON ur.id_rol = r.id_rol 
                                          WHERE ur.id_usuario = :id_usuario)";
            $stmt = $dbh ->prepare($query);
            $stmt -> bindParam(":id_usuario", $id, PDO::PARAM_INT);
            $stmt -> execute();
            $fila = $stmt -> fetchAll();
            return $fila;
        }

       /*
        * Método para asignar un rol a un usuario
        * Params Integer @id_usuario recibe el id del usuario
        * Params Integer @id_rol recibe el id del rol
        * Return Integer con los registros afectados
        */
        function assignRol($id_usuario, $id_rol){
            $dbh = $this -> Connect();
            $sentencia = 'INSERT INTO usuario_rol(id_usuario, id_rol) VALUES(:id_usuario, :id_rol)';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
            $stmt -> bindParam(":id_rol", $id_rol, PDO::PARAM_INT);
            $resultado = $stmt -> execute();
            return $resultado;
        }

       /*
        * Método para eliminar un rol de un usuario
        * Params Integer @id_usuario recibe el id del usuario
        * Params Integer @id_rol recibe el id del rol
        * Return Integer con los registros afectados
        */
        function deleteRol($id_usuario, $id_rol){
            $dbh = $this -> Connect();
            $sentencia = 'DELETE FROM usuario_rol WHERE id_usuario = :id_usuario AND id_rol = :id_rol';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
            $stmt -> bindParam(":id_rol", $id_rol, PDO::PARAM_INT);
            $resultado = $stmt -> execute();
            return $resultado;
        }

      /*
       * Método para extraer la cantidad de roles que existen
       * Return Integer con la cantidad de roles que existen
       */
        function total(){
            $dbh = $this -> Connect();
            $sentencia = "SELECT COUNT(id_rol) AS total FROM rol";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $rows = $stmt -> fetchAll();
            return $rows[0]['total'];
        }
    }
?>