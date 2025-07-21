<?php
session_start();
header('Content-Type: application/json');

include 'conexion.php';

$input = json_decode(file_get_contents('php://input'), true);
$correo = $input['correo'] ?? '';
$contraseña = $input['contraseña'] ?? '';

if (empty($correo) || empty($contraseña)) {
    echo json_encode(['success' => false, 'message' => 'Correo y contraseña son requeridos.']);
    exit;
}

$stmt = $conn->prepare("SELECT boleta, contraseña, es_ganador FROM participantes WHERE correo_institucional = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Usuario no encontrado.']);
    exit;
}

$usuario = $result->fetch_assoc();

if (password_verify($contraseña, $usuario['contraseña'])) {

    if ($usuario['es_ganador'] == 1) {
        
        $_SESSION['ganador_autenticado'] = true;
        $_SESSION['ganador_boleta'] = $usuario['boleta']; 
        
        echo json_encode(['success' => true]);

    } else {
        echo json_encode(['success' => false, 'message' => 'Acceso denegado. Este portal es solo para ganadores.']);
    }
    
} else {
    echo json_encode(['success' => false, 'message' => 'Contraseña incorrecta.']);
}

$stmt->close();
$conn->close();
?>