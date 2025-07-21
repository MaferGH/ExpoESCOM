<?php
include 'conexion.php';

// Recibe los datos JSON desde JS
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["success" => false, "message" => "No se recibieron datos"]);
    exit;
}

try {
    $stmt = $conn->prepare("INSERT INTO participantes 
        (boleta, nombre, apellido_paterno, apellido_materno, genero, curp, telefono, semestre, carrera, concurso, correo_institucional, contraseña, academia, unidad_aprendizaje, horario_preferencia, nombre_proyecto, nombre_equipo) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssssssssssssss",
        $data['boleta'], $data['nombre'], $data['apePater'], $data['apeMater'], $data['genero'],
        $data['curp'], $data['telefono'], $data['semestre'], $data['carrera'], $data['concurso'],
        $data['correo'], password_hash($data['password'], PASSWORD_DEFAULT),
        $data['academia'], $data['unidad_aprendizaje'], $data['horario'],
        $data['proyecto'], $data['equipo']
    );

    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "No se insertó el participante"]);
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>
