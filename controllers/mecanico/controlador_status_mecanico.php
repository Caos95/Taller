<?php
    require '../../models/modelo_mecanico.php';

    $MC=new modelo_Mecanico();
    $id_usuario = htmlspecialchars($_POST['id_usuario'], ENT_QUOTES, 'UTF-8') ;
    $estado = htmlspecialchars($_POST['estado'], ENT_QUOTES, 'UTF-8') ;
    $consulta = $MC->modificar_estado($id_usuario, $estado) ;
    echo $consulta;



?>
