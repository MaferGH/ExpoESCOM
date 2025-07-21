<?php
session_start();
header('Content-Type: application/json');

$conexion = new mysqli("localhost", "root", "", "concurso_registro");
if ($conexion->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión']);
    exit;
}
$conexion->set_charset("utf8mb4");

$input = json_decode(file_get_contents('php://input'), true);
$correo = $input['correo'] ?? '';
$contraseña = $input['contraseña'] ?? '';

if (empty($correo) || empty($contraseña)) {
    echo json_encode(['success' => false, 'message' => 'Correo y contraseña son requeridos']);
    exit;
}

$stmt = $conexion->prepare("SELECT boleta, nombre, apellido_paterno, contraseña, rol FROM participantes WHERE correo_institucional = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
    exit;
}

$row = $result->fetch_assoc();

if (password_verify($contraseña, $row['contraseña'])) {

    $_SESSION['usuario_boleta'] = $row['boleta']; 
    $_SESSION['usuario_nombre'] = $row['nombre'] . ' ' . $row['apellido_paterno'];
    $_SESSION['usuario_rol'] = $row['rol'];

    echo json_encode(['success' => true, 'rol' => $row['rol']]);
} else {
    echo json_encode(['success' => false, 'message' => 'Contraseña incorrecta']);
}

$stmt->close();
$conexion->close();
?>