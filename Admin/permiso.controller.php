<?php
    require_once('sistema.controller.php');

   /*
    * Clase principal para permiso
    */
    class Permiso extends Sistema{

       /*
        * Método para insertar un registro de un permiso a la base de datos Hospital
        * Params String @permiso recibe el nombre del permiso
        * Return Integer con la cantidad de registros afectados
        */
        function create($permiso){
            $dbh = $this->connect();
            $sentencia = "INSERT INTO permiso(permiso) VALUES(:permiso)";
            $stmt= $dbh->prepare($sentencia);
            $stmt->bindParam(':permiso', $permiso, PDO::PARAM_STR);
            $resultado = $stmt->execute();
            return $resultado;
        }

       /*
        * Método para obtener todos los permisos
        * Return Array con todos los permisos por cantidades
        */
        function read(){
            $dbh = $this -> Connect();
            $busqueda = (isset($_GET['busqueda']))?$_GET['busqueda']:'';
            $ordenamiento = (isset($_GET['ordenamiento']))?$_GET['ordenamiento']:'p.producto';
            $limite = (isset($_GET['limite']))?$_GET['limite']:'5';
            $desde = (isset($_GET['desde']))?$_GET['desde']:'0';
            $sentencia = 'SELECT * FROM permiso p WHERE p.permiso LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
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
        * Método para obtener la información de un solo permiso
        * Params Integer @id_permiso recibe el id del permiso
        * Return Array con la información del permiso
        */
        function readOne($id_permiso)
        {
            $dbh = $this->connect();
            $sentencia='SELECT * FROM permiso WHERE id_permiso = :id_permiso';
            $stmt = $dbh->prepare($sentencia);
            $stmt->bindParam(':id_permiso', $id_permiso, PDO::PARAM_INT);
            $stmt->execute();
            $filas=$stmt->fetchAll();
            return $filas;
        }

       /*
        * Método para actualizar un registro de un permiso a la base de datos Hospital
        * Params Integer @id_permiso recibe el id del permiso
        * Params String  @permiso recibe el nombre del permiso
        * Return Integer con la cantidad de registros afectados
        */
        function update($id_permiso,$permiso)
        {
            $dbh = $this->connect();
            $sentencia = 'UPDATE permiso SET permiso = :permiso WHERE id_permiso = :id_permiso';
            $stmt= $dbh->prepare($sentencia);
            $stmt->bindParam(':id_permiso', $id_permiso, PDO::PARAM_INT);
            $stmt->bindParam(':permiso', $permiso, PDO::PARAM_STR);
            $resultado = $stmt->execute();
            return $resultado;
        }

       /*
        * Método para eliminar un solo permiso
        * Params Integer @id_permiso recibe el id del permiso
        * Return Integer con los registros afectados
        */
        function delete($id_permiso)
        {
            $dbh = $this->connect();
            $dbh -> beginTransaction();
            try{
                $sentencia = 'DELETE FROM rol_permiso WHERE id_permiso = :id_permiso';
                $stmt= $dbh -> prepare($sentencia);
                $stmt -> bindParam(':id_permiso', $id_permiso, PDO::PARAM_INT);
                $resultado = $stmt -> execute();
                $sentencia = 'DELETE FROM permiso WHERE id_permiso = :id_permiso';
                $stmt= $dbh -> prepare($sentencia);
                $stmt -> bindParam(':id_permiso', $id_permiso, PDO::PARAM_INT);
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
        * Método para obtener los permisos de un rol
        * Params Integer @id recibe el id del rol
        * Return Arreglo con los permisos del rol
        */
        function getPermisosRol($id){
            $dbh = $this ->Connect();
            $query = "SELECT p.id_permiso, p.permiso FROM permiso p 
                            JOIN rol_permiso rp ON p.id_permiso = rp.id_permiso 
                            JOIN rol r ON rp.id_rol = r.id_rol 
                      WHERE r.id_rol = :id_rol";
            $stmt = $dbh ->prepare($query);
            $stmt -> bindParam(":id_rol", $id, PDO::PARAM_INT);
            $stmt -> execute();
            $fila = $stmt -> fetchAll();
            return $fila;
        }

       /*
        * Método para obtener los permisos disponibles de un rol
        * Params Integer @id recibe el id del rol
        * Return Arreglo con los permisos disponibles del rol
        */
        function getPermisosRolAvailable($id){
            $dbh = $this ->Connect();
            $query = "SELECT id_permiso, permiso FROM permiso 
                      WHERE id_permiso NOT IN(SELECT p.id_permiso FROM permiso p 
                                                    JOIN rol_permiso rp ON p.id_permiso = rp.id_permiso 
                                                    JOIN rol r ON rp.id_rol = r.id_rol 
                                               WHERE r.id_rol = :id_rol)";
            $stmt = $dbh ->prepare($query);
            $stmt -> bindParam(":id_rol", $id, PDO::PARAM_INT);
            $stmt -> execute();
            $fila = $stmt -> fetchAll();
            return $fila;
        }

       /*
        * Método para asignar un permiso a un rol
        * Params Integer @id_rol recibe el id del rol
        * Params Integer @id_permiso recibe el id del permiso
        * Return Integer con los registros afectados
        */
        function assignPermiso($id_rol, $id_permiso){
            $dbh = $this -> Connect();
            $sentencia = 'INSERT INTO rol_permiso(id_rol, id_permiso) VALUES(:id_rol, :id_permiso)';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindParam(":id_rol", $id_rol, PDO::PARAM_INT);
            $stmt -> bindParam(":id_permiso", $id_permiso, PDO::PARAM_INT);
            $resultado = $stmt -> execute();
            return $resultado;
        }

       /*
        * Método para eliminar un permiso de un rol
        * Params Integer @id_rol recibe el id del rol
        * Params Integer @id_permiso recibe el id del permiso
        * Return Integer con los registros afectados
        */
        function deletePermiso($id_rol, $id_permiso){
            $dbh = $this -> Connect();
            $sentencia = 'DELETE FROM rol_permiso WHERE id_rol = :id_rol AND id_permiso = :id_permiso';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindParam(":id_rol", $id_rol, PDO::PARAM_INT);
            $stmt -> bindParam(":id_permiso", $id_permiso, PDO::PARAM_INT);
            $resultado = $stmt -> execute();
            return $resultado;
        }

       /*
        * Método para extraer la cantidad de permisos que existen
        * Return Integer con la cantidad de permisos que existen
        */
        function total(){
            $dbh = $this -> Connect();
            $sentencia = "SELECT COUNT(id_permiso) AS total FROM permiso";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $rows = $stmt -> fetchAll();
            return $rows[0]['total'];
        }
    }
?>