<?php
class modelo_Rol{

    private $conexion;
    public function __construct() {
        require_once 'modelo_conexion.php';
        $this->conexion = new conexion();
        $this->conexion->conectar();
    }
    public function cerrarConexion(){
        $this->conexion->cerrar();
    }

    public function listar_rol(){
        $sql= "CALL SP_LISTAR_ROL";
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

        public function agregar_rol($nombre_rol){
            $sql='CALL SP_REGISTRAR_ROL(?)';
            $stmt = $this->conexion->conexion->prepare($sql);
            if ($stmt===false) {
                return 0;
            }
            $stmt->bind_param("s", $nombre_rol);
            try {
                if ($stmt->execute()) {
                    $stmt->close();
                    return 1; // Éxito
                }
            } catch (mysqli_sql_exception $e) {
                $stmt->close();
                // 1062 es el código de error para una entrada duplicada
                if ($e->getCode() == 1062) {
                    return 2; // Indica un duplicado
                } else {
                    return 0; // Indica un error general
                }
            }
            // En caso de que execute() devuelva false sin una excepción
            $stmt->close();
            return 0;
        }


}
?>