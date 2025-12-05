<?php 
require "../../models/modelo_usuario.php";

// Establecer la cabecera para indicar que la respuesta es JSON.
header('Content-Type: application/json');

$MU = new Modelo_Usuario();
$consulta = $MU->listar_usuario();

// Si la consulta no devuelve un array (por ejemplo, devuelve false), 
// lo convertimos en un array vacío para mantener la consistencia.
$data = $consulta ? $consulta : [];

$response = [
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
];

echo json_encode($response);
?>