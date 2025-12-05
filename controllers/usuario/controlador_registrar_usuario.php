<?php
require "../../models/modelo_usuario.php";
$MU = new Modelo_Usuario();

$usuario = htmlspecialchars($_POST['usuario'], ENT_QUOTES, 'UTF-8');
$contra = htmlspecialchars($_POST['contra'], ENT_QUOTES, 'UTF-8');
$estado = htmlspecialchars($_POST['estado'], ENT_QUOTES, 'UTF-8'); // Se espera 1 para activo, 0 para inactivo
$nombre = htmlspecialchars($_POST['nombre'], ENT_QUOTES, 'UTF-8');
$apellido = htmlspecialchars($_POST['apellido'], ENT_QUOTES, 'UTF-8');
$rut = htmlspecialchars($_POST['rut'], ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
$telefono = htmlspecialchars($_POST['telefono'], ENT_QUOTES, 'UTF-8');
$sexo = htmlspecialchars($_POST['sexo'], ENT_QUOTES, 'UTF-8');
$rol = htmlspecialchars($_POST['rol'], ENT_QUOTES, 'UTF-8');

$consulta = $MU->agregarUsuario($usuario, $contra, $estado, $nombre, $apellido, $rut, $email, $telefono, $sexo, $rol);
echo $consulta;