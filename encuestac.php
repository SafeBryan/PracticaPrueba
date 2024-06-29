<?php
require_once 'conexion.php';

class Encuesta {
    private $conn;

    public function __construct() {
        $conexion = new Conexion();
        $this->conn = $conexion->conectar();
    }

    public function guardarEncuesta($usuario_id, $respuesta1, $respuesta2) {
        $stmt = $this->conn->prepare("INSERT INTO encuestas (usuario_id, pregunta1_respuesta, pregunta2_respuesta) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $usuario_id, $respuesta1, $respuesta2);
        return $stmt->execute();
    }

    public function existeEncuestaUsuario($usuario_id) {
        $stmt = $this->conn->prepare("SELECT * FROM encuestas WHERE usuario_id = ?");
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function obtenerRespuestas() {
        $result = $this->conn->query("SELECT * FROM encuestas");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
