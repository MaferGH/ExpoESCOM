<?php
include 'conexion.php';
header('Content-Type: application/json');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
  echo json_encode(["success" => false, "error" => "ID inválido"]);
  exit;
}

$stmt = $conn->prepare("SELECT * FROM participantes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($fila = $result->fetch_assoc()) {
  echo json_encode(["success" => true, "participante" => $fila]);
} else {
  echo json_encode(["success" => false, "error" => "Participante no encontrado"]);
}

$stmt->close();
$conn->close();
?>
