<?php
class Modelo_Usuario
{
    private $conexion;

    // El constructor se encarga de requerir la conexión y establecerla.
    function __construct()
    {
        require_once('modelo_conexion.php');
        $this->conexion = new Conexion();
        $this->conexion->conectar();
    }

    // Función para cerrar la conexión, llamada desde el controlador.
    function cerrarConexion()
    {
        $this->conexion->cerrar();
    }

    // Función que llama al procedimiento almacenado para verificar el usuario.
    function VerificarUsuario($usuario)
    {
        $sql = "CALL SP_VERIFICAR_USUARIO(?)";
        $stmt = $this->conexion->conexion->prepare($sql);
        if ($stmt === false) {
            return null;
        }

        $stmt->bind_param("s", $usuario);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            $datos = $resultado->fetch_assoc();
            $stmt->close();
            // La conexión no se cierra aquí para poder reutilizarla.
            return $datos;
        }

        $stmt->close();
        return null;
    }

    function TraerDatos($usuario)
    {
        // Usamos el método seguro con consultas preparadas. Este SP trae todos los datos.
        $sql = "CALL SP_VERIFICAR_USUARIO(?)";
        $stmt = $this->conexion->conexion->prepare($sql);
        if ($stmt === false) {
            return []; // Devolver un array vacío si la preparación falla
        }
     
        $stmt->bind_param("s", $usuario);
        $arreglo = array();
 
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            // Usamos fetch_assoc() para obtener un array asociativo con los nombres de las columnas.
            if ($datos = $resultado->fetch_assoc()) {
                $arreglo = $datos;
            }
        }
 
        // Cerramos el statement
        $stmt->close();
        return $arreglo;
    }

    function listar_usuario()
    {
        // La consulta original no usaba parámetros, así que se llama directamente.
        $sql = "CALL SP_LISTAR_USUARIO()";
        $stmt = $this->conexion->conexion->prepare($sql);
        if ($stmt === false) {
            // Si la preparación falla, devuelve un array vacío.
            return [];
        }

        $arreglo = array();
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            // Itera sobre los resultados y los añade al array.
            while ($datos = $resultado->fetch_assoc()) {
                $arreglo[] = $datos;
            }
        }
        
        $stmt->close();
        return $arreglo;
    }

    // Nueva función para obtener el nombre real del usuario
    function obtenerInfoUsuario($id_usuario)
    {
        $sql = "CALL SP_OBTENER_INFO_USUARIO(?)";
        $stmt = $this->conexion->conexion->prepare($sql);
        if ($stmt === false) {
            return null;
        }

        $stmt->bind_param("i", $id_usuario);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            $datos = $resultado->fetch_assoc();
            $stmt->close();
            return $datos;
        }

        $stmt->close();
        return null;
    }

    function listar_combo_rol()
    {
        $sql = "CALL SP_LISTAR_COMBO_ROL()";
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

    function agregarUsuario($usuario, $contra, $estado, $nombre, $apellido, $rut, $email, $telefono, $sexo, $rol)
    {
        $sql = "CALL SP_REGISTRAR_USUARIO(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->conexion->prepare($sql);
        if ($stmt === false) {
            // Error en la preparación de la consulta
            return 0;
        }

        // Hashear la contraseña antes de guardarla
        $contra_hash = password_hash($contra, PASSWORD_DEFAULT, ['cost' => 10]);

        // s: string, i: integer
        $stmt->bind_param("ssissssssi", $usuario, $contra_hash, $estado, $nombre, $apellido, $rut, $email, $telefono, $sexo, $rol);

        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            if ($fila = $resultado->fetch_assoc()) {
                $stmt->close();
                return (int)$fila['resultado']; // Devuelve 1 (éxito), 2 (usuario duplicado), 3 (rut duplicado), 4 (email duplicado)
            }
        }

        $stmt->close();
        return 0; // 0: Error general
    }

    function modificarUsuario($id, $nombres, $apellidos, $email, $telefono, $sexo, $contra)
    {
        $sql = "CALL SP_MODIFICAR_USUARIO(?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->conexion->prepare($sql);
        if ($stmt === false) {
            return 0; // Error en la preparación
        }

        $contra_hash = null;
        if (!empty($contra)) {
            $contra_hash = password_hash($contra, PASSWORD_DEFAULT, ['cost' => 10]);
        }

        // i: integer, s: string
        $stmt->bind_param("issssss", $id, $nombres, $apellidos, $email, $telefono, $sexo, $contra_hash);

        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            if ($fila = $resultado->fetch_assoc()) {
                $stmt->close();
                return (int)$fila['resultado']; // Devuelve 1 (éxito) o 2 (email duplicado)
            }
        }
        $stmt->close();
        return 0; // Error general
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