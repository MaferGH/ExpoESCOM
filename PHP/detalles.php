<?php
include 'conexion.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id'])) {
  echo json_encode(["success" => false, "error" => "ID no proporcionado"]);
  exit;
}

$id = intval($data['id']);
$stmt = $conn->prepare("SELECT * FROM participantes WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
  $resultado = $stmt->get_result();
  if ($resultado->num_rows === 1) {
    $fila = $resultado->fetch_assoc();
    echo json_encode(["success" => true, "participante" => $fila]);
  } else {
    echo json_encode(["success" => false, "error" => "Participante no encontrado"]);
  }
} else {
  echo json_encode(["success" => false, "error" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
