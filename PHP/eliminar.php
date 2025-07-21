<?php
include 'conexion.php';
header('Content-Type: application/json');

// Recibir datos JSON POST
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id'])) {
    echo json_encode(["success" => false, "error" => "ID no proporcionado"]);
    exit;
}

$id = $data['id'];

// Preparar y ejecutar delete
$stmt = $conn->prepare("DELETE FROM participantes WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "ID no encontrado"]);
    }
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>

