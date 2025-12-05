<?php 
class modelo_servicio{
    private $conexion;

    public function __construct() {
        require_once 'modelo_conexion.php';
        $this->conexion = new conexion();
        $this->conexion->conectar_pdo();
    }

    public function agregarServicio($id_vehiculo, $id_taller, $id_mecanico, $fecha_servicio, $descripcion, $costo){
        try {
            $sql="CALL SP_REGISTRAR_SERVICIO(:id_vehiculo, :id_taller, :id_mecanico, :fecha_servicio, :descripcion, :costo)";
            $stmt = $this->conexion->pdo->prepare($sql);
            $stmt->bindParam(":id_vehiculo", $id_vehiculo,PDO::PARAM_INT);
            $stmt->bindParam(":id_taller", $id_taller, PDO::PARAM_INT);
            $stmt->bindParam(":id_mecanico", $id_mecanico,PDO::PARAM_INT);
            $stmt->bindParam("fecha_servicio", $fecha_servicio,PDO::PARAM_STR);
            $stmt->bindParam(":descripcion", $descripcion,PDO::PARAM_STR);
            $stmt->bindParam(":costo", $costo, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount()>0;

        } catch (PDOException $e) {
            error_log("error al agregar servicios". $e->getMessage());
            return false;
        }
    }

    public function modificarServicio($id_servicio, $descripcion, $costo){
        try {
            $sql = "CALL SP_MODIFICAR_SERVICIO(:id_servicio, :descripcion, :costo)";
            $stmt = $this->conexion->pdo->prepare($sql);
            $stmt->bindParam(":id_servicio", $id_servicio,PDO::PARAM_INT);
            $stmt->bindParam(":descripcion", $descripcion,PDO::PARAM_STR);
            $stmt->bindParam(":costo", $costo, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->rowCount()> 0;

        } catch (PDOException $e) {
            error_log("error al modificar servicios". $e->getMessage());
            return false;   
        }
    }

    public function listar_Servicio(){
        try {
            $sql="CALL SP_LISTAR_SERVICIO";
            $stmt = $this->conexion->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("error al listar servicios". $e->getMessage());
            return false;   
        }
    }
}
?>
