<?php
include 'conexion.php';

header('Content-Type: application/json');

$response = [
    'success' => false,
    'ganadores' => []
];

try {
    $sql = "SELECT * FROM participantes WHERE es_ganador = 1 ORDER BY nombre ASC";
    
    $result = $conn->query($sql);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $response['ganadores'][] = $row;
        }
        $response['success'] = true;
    } else {
        throw new Exception("Error al ejecutar la consulta: " . $conn->error);
    }

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

$conn->close();
echo json_encode($response);
?>