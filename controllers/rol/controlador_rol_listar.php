<?php 
require "../../models/modelo_rol.php";
header('Content-Type: application/json');
$MR = new Modelo_Rol();
$consulta = $MR->listar_rol();
$data = $consulta ? $consulta : [];

$response = [
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
];

echo json_encode($response);

?>

