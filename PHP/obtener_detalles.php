<?php
include 'conexion.php';
header('Content-Type: application/json');

$id = $_GET['id'] ?? null;

if (!$id) {
  echo json_encode(["success" => false, "error" => "ID no proporcionado"]);
  exit;
}

$stmt = $conn->prepare("SELECT * FROM participantes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
  echo json_encode($row);
} else {
  echo json_encode(["success" => false, "error" => "Participante no encontrado"]);
}
?>
