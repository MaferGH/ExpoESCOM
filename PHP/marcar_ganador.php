<?php
include 'verificar_admin.php'; 
include 'conexion.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? 0;
$es_ganador = isset($data['es_ganador']) && $data['es_ganador'] ? 1 : 0; 

if (empty($id)) {
    echo json_encode(['success' => false, 'message' => 'ID de participante no proporcionado.']);
    exit;
}

$stmt = $conn->prepare("UPDATE participantes SET es_ganador = ? WHERE id = ?");
$stmt->bind_param("ii", $es_ganador, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Estado de ganador actualizado.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al actualizar el estado.']);
}

$stmt->close();
$conn->close();
?>