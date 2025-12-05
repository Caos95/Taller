<?php
    require '../../models/modelo_taller.php';
    
    $MT = new modelo_Taller();
    $consulta = $MT->listar_combo_taller();
    if($consulta){
        echo json_encode($consulta);
    }else{
        echo '{
            "sEcho": 1,
            "iTotalRecords": "0",
            "iTotalDisplayRecords": "0",
            "aaData": []
        }';
    }
?>