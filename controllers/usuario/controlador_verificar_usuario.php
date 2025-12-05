<?php
// Incluimos el modelo de usuario que se conectará a la base de datos.
// La ruta debe ser correcta según tu estructura de carpetas.
session_start(); // Iniciar la sesión al principio del script.

require_once '../../models/modelo_usuario.php';

// Establecemos la cabecera para indicar que la respuesta será un JSON.
// Esto es crucial para que el frontend lo interprete correctamente.
header('Content-Type: application/json');

// Creamos una instancia del modelo de usuario.
$MU = new Modelo_Usuario();

// Recogemos los datos del POST y los limpiamos para evitar inyecciones XSS.
$usuario = htmlspecialchars($_POST['usu'], ENT_QUOTES, 'UTF-8');
$contra = htmlspecialchars($_POST['con'], ENT_QUOTES, 'UTF-8');

// Llamamos a la función del modelo para obtener los datos del usuario.
$consulta = $MU->VerificarUsuario($usuario);

// Preparamos un array para la respuesta.
$response = [];

if ($consulta) {
    // Si el usuario existe en la BD, verificamos la contraseña.
    if (password_verify($contra, $consulta['clave'])) {
        // Si la contraseña es correcta, verificamos si el usuario está activo.
        if ($consulta['estado'] == '1') {
            // Llamamos a la función para obtener el nombre real.
            $datos_usuario = $MU->obtenerInfoUsuario($consulta['id_usuario']);

            // Si está activo, iniciamos la sesión y guardamos sus datos.
            $_SESSION['S_IDUSUARIO'] = $consulta['id_usuario'];
            $_SESSION['S_USUARIO'] = $consulta['nombre_usuario'];
            $_SESSION['S_ROL'] = $consulta['nombre_rol'];
            // Guardamos el nombre real en la sesión.
            $_SESSION['S_NOMBRECOMPLETO'] = $datos_usuario['nombre_completo'];
            $response['status'] = 'OK'; // Estado para login exitoso.
        } else {
            // Si no está activo, el usuario está bloqueado.
            $response['status'] = 'BLOCKED'; // Estado para usuario bloqueado.
        }
    } else {
        // Si la contraseña es incorrecta.
        $response['status'] = 'ERROR'; // Estado para credenciales incorrectas.
    }
} else {
    // Si el usuario no existe en la BD.
    $response['status'] = 'ERROR'; // Estado para credenciales incorrectas.
}

// Cerramos la conexión a la base de datos.
$MU->cerrarConexion();

// Convertimos el array de respuesta a formato JSON y lo enviamos al frontend.
echo json_encode($response);
exit(); // Detenemos la ejecución para asegurar una respuesta limpia.
