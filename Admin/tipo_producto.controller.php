<?php 
    require_once('sistema.controller.php');
    class Tipo_producto extends Sistema
    {
        var $id_tipo_producto;
        var $tipo_producto;  
        
        function getId_tipo_producto()
        {
            return $this->id_tipo_producto;
        }
        function setId_tipo_producto($id_tipo_producto){
            $this-> id_tipo_producto = $id_tipo_producto;
        }
        function getTipo_producto()
        {
            return $this->tipo_producto;
        }
        function setTipo_producto($tipo_producto)
        {
            $this-> tipo_producto = $tipo_producto;
        }

            /*
            Este metodo nos sirve para crear un tipo de producto
            Parámetros String @tipo de producto recibe el nombre del tipo de producto
            Returns integer de los registros afectados                
            */
        function create($tipo_producto)
        {
            $dbh = $this->Connect();
            $sentencia = "INSERT INTO tipo_producto(tipo_producto) VALUES (:tipo_producto)";
            $stmt = $dbh->prepare($sentencia);
            $stmt->bindParam(':tipo_producto',$tipo_producto, PDO::PARAM_STR);
            $resultado = $stmt->execute();
            return $resultado;
        }

            /*
            Este metodo nos sirve para poder obtener los tipos de productos
            Returns Array
            */
        function read(){
            $dbh = $this->Connect();
            $sentencia = ("SELECT * FROM tipo_producto");
            $stmt = $dbh->prepare($sentencia);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            return $rows;

        }

            /*
            Este metodo nos sirve para poder obtener uno solo tipo de producto
            params int @id_paciente ID del tipo de producto
            Returns Array
            
            */
        function readOne($id_tipo_producto){
            $dbh = $this->Connect();
            $this->setId_tipo_producto($id_tipo_producto);
            $sentencia = "SELECT * FROM tipo_producto where id_tipo_producto= :id_tipo_producto";
            $stmt = $dbh->prepare($sentencia);
            $stmt->bindParam(':id_tipo_producto',$id_tipo_producto, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            return $rows;
        }

            /*
            Este metodo nos sirve para actualizar un tipo de producto
            Parámetros  int @id_tipo_producto recibe el identificador del tipo del producto
                        String @tipo de producto recibe el nombre del tipo de producto
            Returns integer de los registros afectados                
            */
        function update($id_tipo_producto, $tipo_producto){
            $dbh = $this->Connect();
            $sentencia="UPDATE tipo_producto 
                            SET tipo_producto=:tipo_producto 
                            where id_tipo_producto=:id_tipo_producto";
            $stmt = $dbh->prepare($sentencia);
            $stmt->bindParam(':id_tipo_producto',$id_tipo_producto, PDO::PARAM_STR);
            $stmt->bindParam(':tipo_producto',$tipo_producto, PDO::PARAM_STR);
            $resultado = $stmt->execute();
            return $resultado;
        }

            /*
            Metodo para poder eliminar un tipo de producto
            Params int @id_tipo_producto id de producto
            Returns integer
            */
        function delete($id_tipo_producto){
            $dbh=$this->Connect();
            $sentencia = "delete FROM tipo_producto where id_tipo_producto=:id_tipo_producto";
            $stmt = $dbh->prepare($sentencia);
            $stmt->bindParam(':id_tipo_producto',$id_tipo_producto, PDO::PARAM_STR);
            $resultado = $stmt->execute();
            return $resultado;
        }
    }
    $producto = new Tipo_producto();
    $resultado;
?>
