<?php 
    require_once('sistema.controller.php');
    $sistema = new Sistema;
    class Consulta extends Sistema{

        /*
         * Metodo para leer todas la consultas
         * returns array
         */
        function read($id_paciente){
            $dbh = $this->Connect();
            $sentencia = "SELECT c.padecimiento, c.id_consulta,c.fecha,CONCAT(d.nombre,' ',d.apaterno,' ',d.amaterno)as doctor FROM consulta c join doctor d on d.id_doctor=c.id_doctor where id_paciente=:id_paciente";
            $stmt = $dbh->prepare($sentencia);
            $stmt->bindParam(':id_paciente',$id_paciente, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            return $rows;
        }

        /*
         * Metodo para crear una consulta
         * params:  String  @id_paciente: recibira el identificador del paciente
         *          String  @id_doctor: recibira el identificador del doctor
         *          String  @padecimiento: recibira el padecimiento del paciente
         *          string  @tratamiento: Recibira el tratamiento del paciente
         *          String  @fecha: Recibira la fecha 
         * returns integer
         */
        function create($id_paciente,$padecimiento,$tratamiento){
            $dbh = $this->Connect();
           $sentencia = "INSERT INTO consulta(id_paciente,id_doctor,padecimiento,tratamiento,fecha) 
            VALUES(:id_paciente,:id_doctor,:padecimiento,:tratamiento, now())";
            $stmt = $dbh->prepare($sentencia);
            $stmt->bindParam(':id_paciente',$id_paciente, PDO::PARAM_INT);
            $id_doctor = $this->getIdDoctor($_SESSION['id_usuario']);
            $stmt->bindParam(':id_doctor',$id_doctor, PDO::PARAM_INT);
            $stmt->bindParam(':padecimiento',$padecimiento, PDO::PARAM_STR);
            $stmt->bindParam(':tratamiento',$tratamiento, PDO::PARAM_STR);
            $resultado= $stmt->execute();
            return $resultado;
        }

        /*
         * Metodo para leer una consulta
         * returns array
         */
        function readOne($id_consulta){
            $dbh = $this->Connect();
            $sentencia = "SELECT c.id_consulta, CONCAT(p.nombre,' ',p.apaterno,' ',p.amaterno) as paciente,CONCAT(d.nombre,' ',d.apaterno,' ',d.amaterno) as doctor, c.fecha, c.padecimiento, c.tratamiento FROM consulta c join doctor d on c.id_doctor = d.id_doctor inner join paciente p on p.id_paciente = c.id_paciente WHERE  id_consulta = :id_consulta";
            $stmt = $dbh->prepare($sentencia);
            $stmt->bindParam(':id_consulta', $id_consulta, PDO::PARAM_INT);
            $stmt->execute();
            $resultado = $stmt->fetchAll();
            return $resultado;
        }
    }
?>
