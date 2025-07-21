<?php
require('lib/fpdf/fpdf.php');

function mostrarError($mensaje) {
    die("Error: " . htmlspecialchars($mensaje));
}

$boleta = $_GET['boleta'] ?? '';
if (empty($boleta)) {
    mostrarError("No se proporcionó una boleta.");
}

$conexion = new mysqli("localhost", "root", "", "concurso_registro");
if ($conexion->connect_error) {
    mostrarError("Error de conexión a la base de datos.");
}
$conexion->set_charset("utf8mb4");

$stmt = $conexion->prepare(
    "SELECT * FROM participantes WHERE boleta = ?"
);
$stmt->bind_param("s", $boleta);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows !== 1) {
    mostrarError("Participante no encontrado.");
}
$p = $resultado->fetch_assoc(); 
$stmt->close();
$conexion->close();

class PDF extends FPDF {
    // Cabecera de página
    function Header() {
      
        $this->Image('../recursos/ipn.png', 20, 10, 25); 
        $this->Image('../recursos/escom.png', 171, 10, 25);

        // Fondo oscuro
        $this->SetFillColor(33, 37, 41);
        $this->Rect(0, 0, 216, 50, 'F');

        // Títulos
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 25, utf8_decode('INSTITUTO POLITÉCNICO NACIONAL'), 0, 1, 'C');
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, -5, utf8_decode('ESCUELA SUPERIOR DE CÓMPUTO'), 0, 1, 'C');
        $this->Ln(20); 
    }

    // Pie de página
    function Footer() {
        $this->SetY(-30); 
        $this->SetFont('Arial', 'B', 14);
        $this->SetTextColor(33, 37, 41);
        $this->Cell(0, 10, 'ExpoESCOM 2025', 0, 0, 'C');
    }
}

// Creación del objeto de la clase heredada
$pdf = new PDF('P', 'mm', 'Letter'); 
$pdf->AddPage();

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Times', 'I', 13);
$pdf->Cell(0, 40, utf8_decode('Otorga el presente'), 0, 1, 'C');

$pdf->SetFont('Arial', 'B', 18);
$pdf->Cell(0, -15, utf8_decode('ACUSE DE PARTICIPACIÓN'), 0, 1, 'C');

$nombreCompleto = utf8_decode($p['nombre'] . ' ' . $p['apellido_paterno'] . ' ' . $p['apellido_materno']);
$pdf->SetFont('Times', 'BI', 16);
$pdf->Cell(0, 40, $nombreCompleto, 0, 1, 'C');

function formatearAcademia($id) {
    $map = ["ciencia_datos" => "Ciencia de Datos", "ciencias_basicas" => "Ciencias Básicas", "ciencias_computacion" => "Ciencias de la Computación"];
    return $map[$id] ?? $id;
}

// Lista de datos
$pdf->SetFont('Times', '', 12); 

// Función para formatear la hora 
function formatearHora($hora) {
    if (!$hora || $hora === '00:00:00') {
        return "No Asignado";
    }
    return date("h:i A", strtotime($hora));
}

$pdf->Cell(0, 7, utf8_decode('Boleta: ' . $p['boleta']), 0, 1, 'C');
$pdf->Cell(0, 7, utf8_decode('CURP: ' . $p['curp']), 0, 1, 'C');
$pdf->Cell(0, 7, utf8_decode('Género: ' . $p['genero']), 0, 1, 'C');
$pdf->Cell(0, 7, utf8_decode('Teléfono: ' . $p['telefono']), 0, 1, 'C');
$pdf->Cell(0, 7, utf8_decode('Semestre: ' . $p['semestre']), 0, 1, 'C');
$pdf->Cell(0, 7, utf8_decode('Carrera: ' . $p['carrera']), 0, 1, 'C');
$pdf->Cell(0, 7, utf8_decode('Concurso: ' . $p['concurso']), 0, 1, 'C');
$pdf->Cell(0, 7, utf8_decode('Correo: ' . $p['correo_institucional']), 0, 1, 'C');
$pdf->Cell(0, 7, utf8_decode('Academia: ' . formatearAcademia($p['academia'])), 0, 1, 'C');
$pdf->Cell(0, 7, utf8_decode('Unidad de aprendizaje: ' . $p['unidad_aprendizaje']), 0, 1, 'C');
$pdf->Cell(0, 7, utf8_decode('Salón asignado: ' . $p['salon_asignado']), 0, 1, 'C');
$pdf->Cell(0, 7, utf8_decode('Horario asignado: ' . formatearHora($p['horario_asignado'])), 0, 1, 'C');

// Firmas
$pdf->SetY(210);
$pdf->Line(40, 210, 90, 210);
$pdf->Text(50, 217, utf8_decode('Coordinador Académico'));
$pdf->Line(125, 210, 175, 210);
$pdf->Text(135, 217, utf8_decode('Comité ExpoESCOM'));


$nombreArchivo = 'acuse_expoescom_' . $p['boleta'] . '.pdf';
$pdf->Output('D', $nombreArchivo);
?>