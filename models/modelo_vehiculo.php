<?php
class modelo_Vehiculo{
    
    private $conexion;

    function __construct(){
        require_once 'modelo_conexion.php';
        $this->conexion = new conexion();
        $this->conexion->conectar_pdo();
    }

    function agregarVehiculo($vin,$marca,$modelo,$aniovehiculo,$colorvehiculo, $id_cliente = null){
        try {
            $sql="CALL SP_REGISTRAR_VEHICULO (:vin, :marca, :modelo, :anio, :color, :cliente)";
            $stmt = $this->conexion->pdo->prepare($sql);

            $stmt->bindParam(':vin', $vin, PDO::PARAM_STR);
            $stmt->bindParam(':marca', $marca, PDO::PARAM_STR);
            $stmt->bindParam(':modelo', $modelo, PDO::PARAM_STR);
            $stmt->bindParam(':anio', $aniovehiculo, PDO::PARAM_INT);
            $stmt->bindParam(':color',$colorvehiculo, PDO::PARAM_STR);
            $stmt->bindParam(':cliente',$id_cliente, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->rowCount() >0;
            
        } catch (PDOException $e) {
            error_log("Error al registrar vehiculo: " . $e->getMessage());
            return false;
        }    
    } 
    
    public function listarVehiculo(){
        try {
            $sql = "CALL SP_LISTAR_VEHICULO()";
            $stmt = $this->conexion->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al listar vehiculos: " . $e->getMessage());
            return false;
        }
        
    }

    public function cambiarColor($patente, $color_nuevo){
        try {
            $sql = "CALL SP_MODIFICAR_COLOR(:patente, :color_nuevo)";
            $stmt = $this->conexion->pdo->prepare($sql);
            $stmt->bindParam(":patente", $patente, PDO::PARAM_STR);
            $stmt->bindParam(":color_nuevo", $color_nuevo, pdo::PARAM_STR);      
            $stmt->execute();

            return $stmt->rowCount() > 0;

        } catch (PDOException $e) {
            error_log("Error al modificar color". $e->getMessage());
            return false;
        }
    }
    
}
?>