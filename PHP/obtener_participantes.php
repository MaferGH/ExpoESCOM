<?php
include 'conexion.php';

header('Content-Type: application/json');

$response = [
    'success' => false,
    'total' => 0,
    'ranking' => [],
    'participantes' => [],
    'message' => ''
];

try {

    $sql_participantes = "SELECT * FROM participantes ORDER BY nombre ASC";
    $result_participantes = $conn->query($sql_participantes);

    if ($result_participantes) {
        while ($row = $result_participantes->fetch_assoc()) {
            $response['participantes'][] = $row;
        }
        $response['total'] = $result_participantes->num_rows;
        
    } else {
        throw new Exception("Error al obtener la lista de participantes: " . $conn->error);
    }

    $sql_ranking = "SELECT academia, COUNT(*) as total_proyectos 
                    FROM participantes 
                    WHERE academia IS NOT NULL AND academia != ''
                    GROUP BY academia 
                    ORDER BY total_proyectos DESC 
                    LIMIT 5";
                    
    $result_ranking = $conn->query($sql_ranking);

    if ($result_ranking) {
        while ($row = $result_ranking->fetch_assoc()) {
            $response['ranking'][$row['academia']] = $row['total_proyectos'];
        }
    } else {
        error_log("Advertencia: No se pudo obtener el ranking de academias: " . $conn->error);
    }

    $response['success'] = true;

} catch (Exception $e) {
    http_response_code(500); 
    $response['message'] = $e->getMessage();
}

$conn->close();

echo json_encode($response);
?>