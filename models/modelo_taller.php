<?php
class modelo_Taller{
    private $conexion;

    public function __construct(){
        require_once 'modelo_conexion.php';
        $this->conexion = new conexion;
        $this->conexion->conectar();
    }

public function listar_combo_taller(){
    $sql= "CALL SP_LISTAR_TALLER()";
    $stmt = $this->conexion->conexion->prepare($sql);
    if ($stmt===false) {
        return [];
    }
    $arreglo = array();
    if ($stmt->execute()) {
        $resultado = $stmt->get_result();
        while ($datos = $resultado->fetch_assoc()) {
            $arreglo[] = $datos;
        }
    }
    $stmt->close();
    return $arreglo;
}
}
?>