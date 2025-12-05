<?php
class modelo_Cliente
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

    // Método para registrar un cliente con una transacción
    public function registrar_cliente_completo($usuario, $contra, $sexo, $rol, $rut, $nombre, $direccion, $telefono, $email)
    {
        // Iniciar transacción
        $this->conexion->conexion->begin_transaction();

        try {
            // 1. Registrar el usuario
            $sql_user = 'CALL SP_REGISTRAR_USUARIO(?, ?, ?, ?, 1)'; // 1 = activo
            $stmt_user = $this->conexion->conexion->prepare($sql_user);
            $contra_hash = password_hash($contra, PASSWORD_DEFAULT, ['cost' => 10]);
            $stmt_user->bind_param("ssis", $usuario, $contra_hash, $rol, $sexo);

            if (!$stmt_user->execute()) {
                throw new Exception("Error al registrar el usuario.");
            }

            // 2. Obtener el ID del usuario recién creado
            $id_usuario = $this->conexion->conexion->insert_id;
            $stmt_user->close();

            // 3. Registrar los datos del cliente
            $sql_cliente = 'CALL SP_REGISTRAR_CLIENTE(?, ?, ?, ?, ?, ?)';
            $stmt_cliente = $this->conexion->conexion->prepare($sql_cliente);
            $stmt_cliente->bind_param("sssssi", $rut, $nombre, $direccion, $telefono, $email, $id_usuario);

            if (!$stmt_cliente->execute()) {
                throw new Exception("Error al registrar los datos del cliente.");
            }

            $stmt_cliente->close();

            // Si todo fue exitoso, confirmar la transacción
            $this->conexion->conexion->commit();
            return 1; // Éxito
        } catch (Exception $e) {
            // Si algo falla, revertir la transacción
            $this->conexion->conexion->rollback();
            return 0; // Error
        }
    }
}
?>