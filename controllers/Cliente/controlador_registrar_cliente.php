<?php
    require '../../models/modelo_cliente.php';

    $MC = new modelo_Cliente();

    // Datos del usuario
    $usuario = htmlspecialchars($_POST['usuario'], ENT_QUOTES, 'UTF-8');
    $contra = htmlspecialchars($_POST['contra'], ENT_QUOTES, 'UTF-8');
    $sexo = htmlspecialchars($_POST['sexo'], ENT_QUOTES, 'UTF-8');
    $rol = 2; // ID del rol "cliente"

    // Datos del cliente
    $rut = htmlspecialchars($_POST['rut'], ENT_QUOTES, 'UTF-8');
    $nombre = htmlspecialchars($_POST['nombre'], ENT_QUOTES, 'UTF-8');
    $direccion = htmlspecialchars($_POST['direccion'], ENT_QUOTES, 'UTF-8');
    $telefono = htmlspecialchars($_POST['telefono'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');

    $consulta = $MC->registrar_cliente_completo($usuario, $contra, $sexo, $rol, $rut, $nombre, $direccion, $telefono, $email);
    echo $consulta;
?>