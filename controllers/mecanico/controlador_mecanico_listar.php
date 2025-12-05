<?php
require "../../models/modelo_mecanico.php";
header('content-type:application/json');
$ME = new Modelo_Mecanico();
$consulta = $ME->listar_mecanico();

$data = $consulta ? $consulta : [];

$response = [
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
];

echo json_encode($response);

?>


