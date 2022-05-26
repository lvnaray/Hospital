<?php
    require('sistema.controller.php');

    class Producto extends Sistema{
        var $id_producto;
        var $producto;
        var $precio;
        var $id_tipo_producto;

        function setId_producto($id){
            $this-> id_producto = $id;
 
        }
        function getId_producto(){
         return $this->id_producto;
        }
        function setProducto($nom){
         $this-> producto = $nom;
        }
        function getProducto(){
         return $this->producto;
        }
        function setPrecio($precio){
         $this-> precio = $precio;
        }
        function getPrecio(){
            return $this->precio;
        }
        function setId_tipo_producto($id_tipo_producto){
            $this-> id_tipo_producto = $id_tipo_producto;
           }
           function getId_tipo_producto(){
               return $this->id_tipo_producto;
           }

        /*
        Este metodo nos sirve para crear un producto
        Parámetros String @producto recibe el nombre del producto
                int @precio recibe el apellido paterno del paciente
                int @id_tipo_producto recibe el apellido materno del paciente
        Returns integer de los registros afectados           
                
        */
        function create($producto,$precio,$id_tipo_producto){
            $dbh = $this->Connect();
            $sentencia = "INSERT INTO producto(producto,precio,id_tipo_producto) VALUES (:producto,:precio,:id_tipo_producto)";
            $stmt = $dbh->prepare($sentencia);
            $stmt->bindParam(':producto',$producto, PDO::PARAM_STR);
            $stmt->bindParam(':precio',$precio, PDO::PARAM_INT);
            $stmt->bindParam(':id_tipo_producto',$id_tipo_producto, PDO::PARAM_INT);
            $resultado = $stmt->execute();
            return $resultado;
        }

        /*
        Este metodo nos sirve para poder obtener los productos
        Returns Array
        
        */
        function read(){
            $dbh = $this->Connect();
            $busqueda=(isset($_GET['busqueda']))? $_GET['busqueda']: '';
            $ordenamiento= (isset($_GET['ordenamiento']))? $_GET['ordenamiento']: '';
            $limite=(isset($_GET['limite']))? $_GET['limite']:5;
            $desde= (isset ($_GET['desde']))? $_GET['desde']:0;
            $sentencia = ("SELECT * FROM producto P join tipo_producto TP using(id_tipo_producto) where P.producto like :busqueda order by :ordenamiento limit :limite offset :desde");
            $stmt = $dbh->prepare($sentencia);
            $stmt->bindValue(':busqueda','%'.$busqueda.'%', PDO::PARAM_STR);
            $stmt->bindValue(':ordenamiento',$ordenamiento, PDO::PARAM_STR);
            $stmt->bindValue(':limite',$limite, PDO::PARAM_INT);
            $stmt->bindValue(':desde',$desde, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            return $rows;

        }
        /*
        Este metodo nos sirve para poder obtener uno solo producto
        params int @id_paciente ID del paciente
        Returns Array
        
        */
        function readOne($id_producto){
            $dbh = $this->Connect();
            $sentencia = "SELECT * FROM producto where id_producto= :id_producto";
            $stmt = $dbh->prepare($sentencia);
            $stmt->bindParam(':id_producto',$id_producto, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            return $rows;
        }
        /*
        Este metodo nos sirve para actualizar un producto
        Parámetros: int @id_producto recibe el identificador del producto
                    String @producto recibe el nombre del producto
                    int @precio recibe el precio del producto
                    int @id_tipo_producto recibe el identificador del tipo del producto
        Returns integer de los registros afectados           
                
        */

        function update($id_producto, $producto, $precio, $id_tipo_producto){
            $dbh = $this->Connect();
            $sentencia="UPDATE producto 
                            SET producto=:producto,
                                precio=:precio,
                                id_tipo_producto=:id_tipo_producto  
                            where id_producto=:id_producto";
            $stmt = $dbh->prepare($sentencia); 
            $stmt->bindParam(':id_producto',$id_producto, PDO::PARAM_STR);
            $stmt->bindParam(':producto',$producto, PDO::PARAM_STR);
            $stmt->bindParam(':precio',$precio, PDO::PARAM_STR);
            $stmt->bindParam(':id_tipo_producto',$id_tipo_producto, PDO::PARAM_INT);
            $resultado = $stmt->execute();
            return $resultado;
            
        }

        /*
        Metodo para poder eliminar un producto
        Params int @id_producto id de producto
        Returns integer
        */
        function delete($id_producto){
            $dbh=$this->Connect();
            $sentencia = "delete FROM producto where id_producto=:id_producto";
            $stmt = $dbh->prepare($sentencia);
            $stmt->bindParam(':id_producto',$id_producto, PDO::PARAM_STR);
            $resultado = $stmt->execute();
            return $resultado;
        }

        function total(){
            $dbh = $this->connect();
            $total=0;
            $sentencia="SELECT COUNT(id_producto) as total FROM producto";
            $stmt = $dbh->prepare($sentencia);
            $stmt->execute();
            $resultado =  $stmt->fetchAll();
            return $resultado[0]['total'];
           
        }
    }
?>