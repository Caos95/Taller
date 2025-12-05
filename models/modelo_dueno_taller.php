<?php
class modelo_dueno_Taller{
    private $conexion;
    public function __construct(){
        require_once 'modelo_conexion.php';
        $this->conexion = new conexion;
        $this->conexion->conectar_pdo();
    }

    public function registrarDueno($rut,$nombre,$telefono,$email,$id_usuario){
        try {
            $sql='CALL SP_AGREGAR_DUENO(:rut, :nombre, :telefono, :email, :id_usuario)';
            $stmt = $this->conexion->pdo->prepare($sql);
            $stmt->bindParam(":rut",$rut,PDO::PARAM_STR) ;
            $stmt->bindParam(":nombre", $nombre,PDO::PARAM_STR) ;
            $stmt->bindParam(":telefono", $telefono,PDO::PARAM_STR) ;
            $stmt->bindParam(":email", $email,PDO::PARAM_STR) ;
            $stmt->bindParam(":id_usuario", $id_usuario,PDO::PARAM_INT) ;
            $stmt->execute() ;
            return $stmt->rowCount()>0;
        } catch (PDOException $e) {
            error_log("error al registrar dueño" . $e->getMessage());
            return false;

        }
    }
    public function modificar_Dueno($rut,$nombre,$telefono,$email){
        try {
            $sql= "CALL SP_MODIFICAR_DUENO(:rut,:nombre, :telefono, :email)";
            $stmt = $this->conexion->pdo->prepare($sql);
            $stmt->bindParam(":rut",$rut,PDO::PARAM_STR) ;
            $stmt->bindParam(":nombre", $nombre,PDO::PARAM_STR) ;
            $stmt->bindParam(":telefono", $telefono,PDO::PARAM_STR) ;
            $stmt->bindParam(":email", $email,PDO::PARAM_STR) ;
            $stmt->execute();
            return $stmt->rowCount()> 0;
        } catch (PDOException $e) {
            error_log("error al modificar dueño" . $e->getMessage());
            return false;   
        }
    }
    public function listar_Dueno(){
        try {
            $sql="CALL SP_LISTAR_DUENO";
            $stmt = $this->conexion->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al listar dueños de taller". $e->getMessage());
            return false;
        }
    }


}




?>