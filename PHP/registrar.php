<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

function responderExito($datos = []) {
    $respuesta = array_merge(["status" => "ok"], $datos);
    echo json_encode($respuesta);
    exit;
}
function responderError($mensaje) {
    echo json_encode(["status" => "error", "message" => $mensaje]);
    exit;
}

$conexion = new mysqli("localhost", "root", "", "concurso_registro");
if ($conexion->connect_error) {
    responderError("Conexión fallida: " . $conexion->connect_error);
}
$conexion->set_charset("utf8mb4");

$boleta = trim($_POST['boleta'] ?? '');
$nombre = trim($_POST['nombre'] ?? '');
$ap_paterno = trim($_POST['apePater'] ?? '');
$ap_materno = trim($_POST['apeMater'] ?? '');
$genero = trim($_POST['genero'] ?? '');
$curp = trim($_POST['curp'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$semestre = trim($_POST['semestre'] ?? '');
$carrera = trim($_POST['carrera'] ?? '');
$concurso = trim($_POST['concurso'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$contraseña = $_POST['password'] ?? '';
$academia = trim($_POST['academia'] ?? '');
$unidad = trim($_POST['cursoSelect'] ?? '');
$horario = trim($_POST['horario'] ?? ''); 
$proyecto = trim($_POST['nombre_proyecto'] ?? '');
$equipo = trim($_POST['nombre_equipo'] ?? '');


function asignarSlot($conexion, $academia) {
    $academias_matutino = [
        "ciencias_computacion", 
        "ciencias_sociales", 
        "ingenieria_software", 
        "sistemas_distribuidos"
    ];
    
    $academias_vespertino = [
        "ciencia_datos", 
        "ciencias_basicas", 
        "fundamentos_sistemas", 
        "inteligencia_artificial", 
        "proyectos_estrategicos", 
        "sistemas_digitales"
    ];

    $salones_disponibles = ['2001', '2002', '2003', '2004', '2005'];
    $horarios_matutino = ['10:30:00', '12:00:00'];
    $horarios_vespertino = ['15:00:00', '16:30:00'];
    
    $capacidad_por_salon = count($horarios_matutino);
    $capacidad_total_turno = count($salones_disponibles) * $capacidad_por_salon;

    if (in_array($academia, $academias_matutino)) {
        $turno_academias = $academias_matutino;
        $turno_horarios = $horarios_matutino;
    } else if (in_array($academia, $academias_vespertino)) {
        $turno_academias = $academias_vespertino;
        $turno_horarios = $horarios_vespertino;
    } else {
        return ['salon' => 'N/A', 'horario' => '00:00:00']; 
    }

    $placeholders = implode(',', array_fill(0, count($turno_academias), '?'));
    $stmt = $conexion->prepare("SELECT COUNT(*) as total FROM participantes WHERE academia IN ($placeholders)");
    $tipos_de_dato = str_repeat('s', count($turno_academias));
    $stmt->bind_param($tipos_de_dato, ...$turno_academias);
    $stmt->execute();
    $resultado = $stmt->get_result()->fetch_assoc();
    $total_registrados_en_turno = (int)$resultado['total'];
    $stmt->close();

    if ($total_registrados_en_turno >= $capacidad_total_turno) {
        return ['salon' => 'LLENO', 'horario' => 'LLENO'];
    }

    $indice_salon = floor($total_registrados_en_turno / $capacidad_por_salon);
    $indice_horario = $total_registrados_en_turno % $capacidad_por_salon;
    
    $salon_asignado = $salones_disponibles[$indice_salon];
    $horario_asignado = $turno_horarios[$indice_horario];

    return ['salon' => $salon_asignado, 'horario' => $horario_asignado];
}

$slot = asignarSlot($conexion, $academia);
$salon = $slot['salon'];
$horario_asignado = $slot['horario'];

if ($salon === 'LLENO') {
    responderError("Lo sentimos, ya no hay cupo disponible para las academias de este turno. Por favor, intente más tarde.");
}
if ($salon === 'N/A') {
    responderError("La academia seleccionada no es válida para asignación de horario.");
}

$contraseñaHash = password_hash($contraseña, PASSWORD_DEFAULT);

$stmt = $conexion->prepare("INSERT INTO `participantes` (`boleta`, `nombre`, `apellido_paterno`, `apellido_materno`, `genero`, `curp`, `telefono`, `semestre`, `carrera`, `concurso`, `correo_institucional`, `contraseña`, `academia`, `unidad_aprendizaje`, `horario_preferencia`, `nombre_proyecto`, `nombre_equipo`, `salon_asignado`, `horario_asignado`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

if ($stmt === false) { responderError("Error al preparar la consulta: " . $conexion->error); }

$stmt->bind_param("sssssssssssssssssss",
    $boleta, $nombre, $ap_paterno, $ap_materno, $genero, $curp, $telefono, $semestre, $carrera, $concurso,
    $correo, $contraseñaHash, $academia, $unidad, $horario, $proyecto, $equipo,
    $salon, 
    $horario_asignado 
);

try {
    if ($stmt->execute()) {
        $datos_para_acuse = [ "boleta" => $boleta, "nombre" => $nombre, "apellido_paterno" => $ap_paterno, "curp" => $curp, "genero" => $genero, "telefono" => $telefono, "semestre" => $semestre, "carrera" => $carrera, "concurso" => $concurso, "correo_institucional" => $correo, "academia" => $academia, "unidad_aprendizaje" => $unidad, "nombre_proyecto" => $proyecto, "salon_asignado" => $salon, "horario_asignado" => $horario_asignado ];
        responderExito(["data" => $datos_para_acuse]);
    } else {
        responderError("Error desconocido al guardar el registro: " . $stmt->error);
    }
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1062) {
        responderError("La boleta, CURP o correo electrónico ya se encuentran registrados en el sistema.");
    } else {
        responderError("Error de base de datos: " . $e->getMessage());
    }
}

$stmt->close();
$conexion->close();
?>