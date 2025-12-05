<?php
    require '../../models/modelo_mecanico.php';
    
    $MC= new modelo_Mecanico();
    
    //datos tabla usuario

    $usuario = htmlspecialchars($_POST['usuario'] ?? '', ENT_QUOTES, 'UTF-8');
    $contra = htmlspecialchars($_POST['contra'] ?? '', ENT_QUOTES, 'UTF-8');
    $sexo = htmlspecialchars($_POST['sexo'] ?? '', ENT_QUOTES, 'UTF-8');
    $rol = 4;

    //tabla mecanico

    $rut = htmlspecialchars($_POST['rut_mecanico'] ?? '', ENT_QUOTES, 'UTF-8');
    $nombre = htmlspecialchars($_POST['nombre_mecanico'] ?? '', ENT_QUOTES, 'UTF-8');
    $especialidad = htmlspecialchars($_POST['especialidad_mecanico'] ?? '', ENT_QUOTES, 'UTF-8');
    $telefono = htmlspecialchars($_POST['telefono_mecanico'] ?? '', ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email_mecanico'] ?? '', ENT_QUOTES, 'UTF-8');
    $taller = htmlspecialchars($_POST['taller_mecanico'] ?? '', ENT_QUOTES, 'UTF-8');

    if (empty($usuario) || empty($contra) || empty($sexo) || empty($rut) || empty($nombre) || empty($especialidad) || empty($telefono) || empty($email) || empty($taller)) {
        echo "Error: Todos los campos son obligatorios.";
        exit();
    }   

    $consulta = $MC->registrar_mecanico_completo($usuario, $contra, $sexo, $rol, $rut, $nombre, $especialidad, $telefono, $email, $taller);
    echo $consulta;

?>