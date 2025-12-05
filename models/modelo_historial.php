<?php
class modelo_Historial{
    private $conexion;

    public function __construct() {
        require_once 'modelo_conexion.php';
        $this->conexion = new conexion() ;
        $this->conexion->conectar_pdo() ;
    }

    public function registrarHistorial($id_vehiculo, $id_cliente, $fecha_cambio, $tipo_evento, $observaiones){
        try {
            
            $sql="CALL SP_REGISTRAR_HISTORIAL(:id_vehiculo, :id_cliente, :fecha_cambio, :tipo_evento, :observaciones)";
            $stmt =$this->conexion->pdo->prepare($sql) ;
            $stmt->bindParam(":id_vehiculo", $id_vehiculo,PDO::PARAM_INT) ;
            $stmt->bindParam(":id_cliente", $id_cliente,PDO::PARAM_INT) ;
            $stmt->bindParam(":fecha_cambio", $fecha_cambio,PDO::PARAM_STR) ;
            $stmt->bindParam(":tipo_evento", $tipo_evento,PDO::PARAM_STR) ;
            $stmt->bindParam(":observaciones", $observaiones, PDO::PARAM_STR) ;
            $stmt->execute() ;
            return $stmt->rowCount()>0;

        } catch (PDOException $e) {
            error_log("Error al registrar el historial" .$e->getMessage());
            return false ;  
        }
    }

    public function modificarHistorial($id_historial, $fecha_cambio, $tipo_evento, $observaciones){
        try {
            $sql= "CALL SP_MODIFICAR_HISTORIAL(:id_historial, :fecha_cambio, :tipo_evento, :observaciones)";
            $stmt =$this->conexion->pdo->prepare($sql) ;
            $stmt->bindParam(":id_historial", $id_historial,PDO::PARAM_INT) ;
            $stmt->bindParam(":fecha_cambio", $fecha_cambio,PDO::PARAM_STR) ;
            $stmt->bindParam(":tipo_evento", $tipo_evento,PDO::PARAM_STR) ;
            $stmt->bindParam(":observaciones", $observaciones,PDO::PARAM_STR) ;
            $stmt->execute() ;
            return $stmt->rowCount()> 0;
        } catch (PDOException $e) {
            error_log("Error al modificar el historial" .$e->getMessage());
            return false ;
        }
    }

    public function listarHistorial(){
        try {
            $sql="CALL SP_LISTAR_HISTORIAL";
            $stmt =$this->conexion->pdo->prepare($sql) ;
            $stmt->execute() ;
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ;

        } catch (PDOException $e) {
            error_log("Error al listar el historial" .$e->getMessage());
            return false ;
        }
    }
}



?>