<?php

include 'conexion.php'; 
header('Content-Type: application/json');

function responderExito($mensaje = "Datos actualizados correctamente.") {
    echo json_encode(["success" => true, "message" => $mensaje]);
    exit;
}
function responderError($mensaje) {
    echo json_encode(["success" => false, "message" => $mensaje]);
    exit;
}

// =================================================================================
// 1. OBTENCIÓN Y VALIDACIÓN DE DATOS (FUSIÓN DE AMBOS MÉTODOS)
// =================================================================================

$campos_requeridos = ['id', 'boleta', 'curp', 'nombre', 'apellido_paterno'];
$todos_los_campos = ['id', 'boleta', 'curp', 'nombre', 'apellido_paterno', 'apellido_materno', 'genero', 'telefono',
  'semestre', 'carrera', 'concurso', 'correo_institucional', 'academia',
  'unidad_aprendizaje', 'nombre_proyecto', 'nombre_equipo'];
$datos = [];
foreach ($todos_los_campos as $campo) {
    $datos[$campo] = trim($_POST[$campo] ?? '');
}

foreach ($campos_requeridos as $campo) {
    if (empty($datos[$campo])) {
        responderError("Datos incompletos. El campo '$campo' es obligatorio.");
    }
}

$datos['id'] = intval($datos['id']);

// ==============================================
// 2. PREPARACIÓN Y EJECUCIÓN DE LA CONSULTA SQL
// ==============================================

$stmt = $conn->prepare("UPDATE participantes SET 
  boleta=?, curp=?, nombre=?, apellido_paterno=?, apellido_materno=?, genero=?, telefono=?, semestre=?, carrera=?, 
  concurso=?, correo_institucional=?, academia=?, unidad_aprendizaje=?, horario_preferencia=?, 
  nombre_proyecto=?, nombre_equipo=?
  WHERE id=?");

if ($stmt === false) {
    responderError("Error al preparar la consulta: " . $conn->error);
}

$stmt->bind_param("ssssssssssssssssi", // 16 's' y una 'i'
  $datos['boleta'], $datos['curp'], $datos['nombre'], $datos['apellido_paterno'], $datos['apellido_materno'], 
  $datos['genero'], $datos['telefono'], $datos['semestre'], $datos['carrera'], $datos['concurso'], 
  $datos['correo_institucional'], $datos['academia'], $datos['unidad_aprendizaje'], $datos['horario_preferencia'], 
  $datos['nombre_proyecto'], $datos['nombre_equipo'], $datos['id']
);

// ===========================
// 3. EJECUCIÓN Y RESPUESTA 
// ===========================
try {
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            responderExito("Participante actualizado con éxito.");
        } else {
            responderExito("No se realizaron cambios. Los datos ya estaban actualizados o el ID no fue encontrado.");
        }
    }
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1062) { 
        responderError("Error: La boleta, CURP o correo ya pertenecen a otro participante.");
    } else {
        responderError("Error de base de datos al actualizar: " . $e->getMessage());
    }
}

$stmt->close();
$conn->close();
?>