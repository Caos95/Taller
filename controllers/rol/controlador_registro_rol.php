<?php
require "../../models/modelo_rol.php";
$modelo_rol = new modelo_Rol();
$nombre_rol = htmlspecialchars($_POST['nombre_rol'], ENT_QUOTES, 'UTF-8');


$consulta = $modelo_rol->agregar_rol($nombre_rol);
echo $consulta;