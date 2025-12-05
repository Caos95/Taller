<?php
    require '../../models/modelo_usuario.php';

    // Verificamos que los datos necesarios han sido enviados por POST.
    if (isset($_POST['id_usuario']) && isset($_POST['estado'])) {
        $MU = new Modelo_Usuario();
        $idusuario = htmlspecialchars($_POST['id_usuario'], ENT_QUOTES, 'UTF-8');
        $estado = htmlspecialchars($_POST['estado'], ENT_QUOTES, 'UTF-8');
        
        $consulta = $MU->modificar_estado($idusuario, $estado);
        echo $consulta;
    }
?>