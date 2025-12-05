<?php
require "../../models/modelo_usuario.php";

$MU = new Modelo_Usuario();

// Recolectar y sanitizar los datos del POST
$id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
$nombres = htmlspecialchars($_POST['nombres'], ENT_QUOTES, 'UTF-8');
$apellidos = htmlspecialchars($_POST['apellidos'], ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
$telefono = htmlspecialchars($_POST['telefono'], ENT_QUOTES, 'UTF-8');
$sexo = htmlspecialchars($_POST['sexo'], ENT_QUOTES, 'UTF-8');

// La contraseña es opcional, solo la procesamos si no está vacía.
$contra = !empty($_POST['contra']) ? htmlspecialchars($_POST['contra'], ENT_QUOTES, 'UTF-8') : null;

// Llamar al método del modelo para modificar el usuario
$consulta = $MU->modificarUsuario($id, $nombres, $apellidos, $email, $telefono, $sexo, $contra);

// Devolver el resultado de la operación
echo $consulta;

$MU->cerrarConexion();

?>