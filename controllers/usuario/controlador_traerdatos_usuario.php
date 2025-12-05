<?php
    require '../../models/modelo_usuario.php';

    header('Content-Type: application/json');

    // Es una buena práctica verificar si el dato POST existe antes de usarlo.
    if (!isset($_POST['usu'])) {
        echo json_encode(null); // Devolver null si no se envía el usuario.
        exit();
    }

    $MU = new Modelo_Usuario();
    $usuario = htmlspecialchars($_POST['usu'],ENT_QUOTES,'UTF-8');
    $consulta = $MU->TraerDatos($usuario);
    $MU->cerrarConexion();
    echo json_encode($consulta);

?>
