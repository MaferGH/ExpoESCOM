<?php
require('lib/fpdf/fpdf.php');

function mostrarError($mensaje) {
    header("Content-Type: text/plain");
    die("Error: " . htmlspecialchars($mensaje));
}

$boleta = $_GET['boleta'] ?? '';
if (empty($boleta)) {
    mostrarError("No se proporcionó una boleta.");
}

$conexion = new mysqli("localhost", "root", "", "concurso_registro");
if ($conexion->connect_error) {
    mostrarError("Error de conexión.");
}
$conexion->set_charset("utf8mb4");

$stmt = $conexion->prepare("SELECT * FROM participantes WHERE boleta = ?");
$stmt->bind_param("s", $boleta);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows !== 1) {
    mostrarError("Participante no encontrado.");
}
$p = $resultado->fetch_assoc();
$stmt->close();
$conexion->close();

if ($p['es_ganador'] != 1) {
    mostrarError("Acceso denegado. Este diploma solo está disponible para ganadores.");
}

class PDF_Diploma extends FPDF {
    // Cabecera de página
    function Header() {
        $logoIPN_path = '../recursos/ipn.png';
        $logoESCOM_path = '../recursos/escom.png';

        $this->SetFillColor(33, 37, 41);
        $this->Rect(0, 0, 297, 40, 'F'); 

        // Logos
        $this->Image($logoIPN_path, 30, 10, 25, 20);
        $this->Image($logoESCOM_path, 237, 10, 25, 20);

        // Títulos
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 25);
        $this->Cell(0, 15, utf8_decode('INSTITUTO POLITÉCNICO NACIONAL'), 0, 1, 'C');
        $this->SetFont('Arial', 'B', 20);
        $this->Cell(0, 10, utf8_decode('ESCUELA SUPERIOR DE CÓMPUTO'), 0, 1, 'C');
    }
}

$pdf = new PDF_Diploma('L', 'mm', 'Letter');
$pdf->AddPage();

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Times', 'I', 16);
$pdf->Ln(20); 
$pdf->Cell(0, 10, utf8_decode('Otorga el presente diploma a:'), 0, 1, 'C');

$nombreCompleto = utf8_decode($p['nombre'] . ' ' . $p['apellido_paterno'] . ' ' . $p['apellido_materno']. ' ');
$pdf->SetFont('Times', 'BI', 28);
$pdf->Ln(5);
$pdf->Cell(0, 15, $nombreCompleto, 0, 1, 'C');

$pdf->SetFont('Times', 'I', 14);
$pdf->SetTextColor(201, 176, 55);
$pdf->Ln(2);
$pdf->Cell(0, 10, utf8_decode('Por su destacada participación, innovación y compromiso en la ExpoESCOM 2025'), 0, 1, 'C');
$pdf->SetTextColor(0, 0, 0); 

function formatearAcademia($id) {
    $map = ["ciencia_datos" => "Ciencia de Datos", "ciencias_basicas" => "Ciencias Básicas", "ciencias_computacion" => "Ciencias de la Computación"];
    return $map[$id] ?? $id;
}
$horaFormateada = date("h:i A", strtotime($p['horario_asignado']));

$pdf->SetFont('Times', '', 12);
$pdf->Ln(5);
$pdf->Cell(0, 7, utf8_decode('Proyecto: ' . $p['nombre_proyecto']), 0, 1, 'C');
$pdf->Cell(0, 7, utf8_decode('Academia: ' . formatearAcademia($p['academia']) . ' | Unidad: ' . $p['unidad_aprendizaje']), 0, 1, 'C');
$pdf->Cell(0, 7, utf8_decode('Salón: ' . $p['salon_asignado'] . ' | Horario: ' . $horaFormateada), 0, 1, 'C');

// Firmas
$pdf->SetY(172); 
$pdf->SetLineWidth(0.5);
$pdf->Line(60, 180, 120, 180);
$pdf->Text(77, 188, utf8_decode('Coordinador Académico'));
$pdf->Line(177, 180, 237, 180);
$pdf->Text(187, 188, utf8_decode('Comité ExpoESCOM'));

// 6. Forzar la descarga del PDF
$nombreArchivo = 'diploma_expoescom_' . $p['boleta'] . '.pdf';
$pdf->Output('D', $nombreArchivo); 
?>