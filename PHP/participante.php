<?php
session_start();
header('Content-Type: application/json');

function responder($status, $data) {
    echo json_encode(["status" => $status, "data" => $data]);
    exit;
}

if (!isset($_SESSION['usuario_boleta'])) {
    responder("error", ["message" => "Acceso denegado. Por favor, inicie sesión."]);
}

$conexion = new mysqli("localhost", "root", "", "concurso_registro");
if ($conexion->connect_error) {
    responder("error", ["message" => "Error de conexión."]);
}
$conexion->set_charset("utf8mb4");


$boleta_sesion = $_SESSION['usuario_boleta'];
$stmt = $conexion->prepare(
    "SELECT 
        boleta, nombre, apellido_paterno, curp, genero, telefono, semestre, carrera, 
        concurso, correo_institucional, nombre_proyecto, academia, unidad_aprendizaje, 
        salon_asignado, horario_asignado, es_ganador
     FROM participantes 
     WHERE boleta = ?"
);
$stmt->bind_param("s", $boleta_sesion);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $datos_participante = $resultado->fetch_assoc();
   
    responder("ok", $datos_participante);
} else {
    responder("error", ["message" => "No se encontraron los datos del participante."]);
}

$stmt->close();
$conexion->close();
?>