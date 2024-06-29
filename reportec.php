<?php
require_once 'conexion.php';

class Reporte {
    private $conn;

    public function __construct() {
        $conexion = new Conexion();
        $this->conn = $conexion->conectar();
    }

    public function reportePregunta1() {
        $result = $this->conn->query("SELECT pregunta1_respuesta, COUNT(*) as total FROM encuestas GROUP BY pregunta1_respuesta");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function reportePregunta2() {
        $result = $this->conn->query("SELECT pregunta2_respuesta, COUNT(*) as total FROM encuestas GROUP BY pregunta2_respuesta");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
