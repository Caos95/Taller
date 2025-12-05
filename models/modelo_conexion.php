<?php
class Conexion {
    private $servidor = "localhost";
    private $usuario = "root";
    private $contrasena = ""; // Usualmente vacío en XAMPP por defecto
    private $basedatos = "taller";
    public $conexion;

    public function conectar() {
        $this->conexion = new mysqli($this->servidor, $this->usuario, $this->contrasena, $this->basedatos);
        if ($this->conexion->connect_errno) {
            die("Error al conectar con la base de datos: " . $this->conexion->connect_error);
        }
        $this->conexion->set_charset("utf8");
    }

    public function cerrar() {
        if ($this->conexion) {
            $this->conexion->close();
        }
    }
}
?>
