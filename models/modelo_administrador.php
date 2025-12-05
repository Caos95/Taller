<?php
class modelo_Administrador
{
    private $conexion;
    public function __construct()
    {
        require_once 'modelo_conexion.php';
        $this->conexion = new conexion();
        $this->conexion->conectar();
    }

    public function cerrarConexion()
    {
        $this->conexion->cerrar();
    }

    public function listar_administrador()
    {

        $sql = "CALL SP_LISTAR_ADMINISTRADOR";
        $stmt = $this->conexion->conexion->prepare($sql);
        if ($stmt === false) {
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

    public function agregar_administrador($rut, $nombre, $email, $idusuario)
    {
        $sql = 'CALL SP_REGISTRAR_ADMINISTRADOR(?, ?, ?, ?)';
        $stmt = $this->conexion->conexion->prepare($sql);
        if ($stmt === false) {
            return null;
        }
        $stmt->bind_param("sssi", $rut, $nombre, $email, $idusuario);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function registrar_administrador_completo($usuario, $contra, $sexo, $rol, $rut, $nombre, $email)
    {
        // Iniciar transacción para asegurar que ambas inserciones ocurran o ninguna.
        $this->conexion->conexion->begin_transaction();

        try {
            // 1. Registrar el usuario en la tabla 'usuario'
            $sql_user = 'CALL SP_REGISTRAR_USUARIO(?, ?, ?, ?, 1)'; // 1 = activo
            $stmt_user = $this->conexion->conexion->prepare($sql_user);
            if ($stmt_user === false) {
                throw new Exception("Error al preparar la consulta de usuario.");
            }
            $contra_hash = password_hash($contra, PASSWORD_DEFAULT, ['cost' => 10]);
            $stmt_user->bind_param("ssis", $usuario, $contra_hash, $rol, $sexo);

            if (!$stmt_user->execute()) {
                throw new Exception("Error al registrar el usuario. Puede que el nombre de usuario ya exista.");
            }

            // 2. Obtener el ID del usuario recién insertado.
            $id_usuario = $this->conexion->conexion->insert_id;
            $stmt_user->close();

            if (empty($id_usuario)) {
                throw new Exception("No se pudo obtener el ID del usuario recién creado.");
            }

            // 3. Registrar los datos del administrador en 'administrador_usuario'
            // Reutilizamos el método que ya tenías, ¡lo cual es una buena práctica!
            if (!$this->agregar_administrador($rut, $nombre, $email, $id_usuario)) {
                 throw new Exception("Error al registrar los datos del administrador. Puede que el RUT ya exista.");
            }

            // 4. Si todo fue exitoso, confirmar la transacción
            $this->conexion->conexion->commit();
            return 1; // Éxito
        } catch (Exception $e) {
            // 5. Si algo falla, revertir la transacción para no dejar datos inconsistentes
            $this->conexion->conexion->rollback();
            // Verificamos si el error es por una entrada duplicada
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                return 2; // Código específico para duplicados
            } else {
                // Devolvemos 0 para cualquier otro tipo de error
                return 0;
            }
        }
    }
    public function listar_combo_rol()
    {
        $sql = "CALL SP_LISTAR_COMBO_ADMINISTRADOR()";
        $stmt = $this->conexion->conexion->prepare($sql);
        if ($stmt === false) {
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

    public function modificar_estado($id_usuario, $estado)
    {
            // Convertimos el estado 'ACTIVO' a 1, y cualquier otro valor a 0.
            $estado_int = 0;
            if ($estado == 'ACTIVO') {
                $estado_int = 1;
            }

            // El procedimiento almacenado SP_MODIFICAR_ESTADO espera dos enteros (id_usuario, estado).
            $sql = "CALL SP_MODIFICAR_ESTADO(?, ?)";
            $stmt = $this->conexion->conexion->prepare($sql);
            if ($stmt === false) {
                return 0;
            }
            
            // Usamos "ii" para indicar que ambos parámetros son enteros.
            $stmt->bind_param("ii", $id_usuario, $estado_int);

            if($stmt->execute()){
                // Verificamos si la consulta realmente afectó a alguna fila.
                if ($stmt->affected_rows > 0) {
                    $stmt->close();
                    return 1; // Éxito, se modificó una fila.
                }
            }
            $stmt->close();
            return 0; // No se modificó ninguna fila o hubo un error.
    }
}
?>