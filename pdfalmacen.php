<?php
require_once('tcpdf/tcpdf.php');

// Conexión a la base de datos
$host = "localhost";
$user = "root";
$pass = "";
$db = "almacen";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta los registros
$sql = "SELECT id, ninventario, marca, narticulo, nprovedor, imagenmarca, imagenarticulo FROM registroalmacen";
$result = $conn->query($sql);
if (!$result) {
    die("Error en la consulta SQL: " . $conn->error);
}

// Creacion del new PDF
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 8);



// Título
$pdf->Cell(0, 10, 'Registro de Inventario de Almacén', 0, 1, 'C');

// Encabezados
$pdf->SetFillColor(200, 220, 255);
$pdf->SetTextColor(0);
$pdf->SetDrawColor(100, 100, 100);

$pdf->Cell(10, 10, 'ID', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Inventario', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Marca', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Artículo', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Proveedor', 1, 0, 'C', true);
$pdf->Cell(33, 10, 'Imagen Marca', 1, 0, 'C', true);
$pdf->Cell(33, 10, 'Imagen Artículo', 1, 1, 'C', true);

while ($row = $result->fetch_assoc()) {
    // Altura 
    $rowHeight = 23;

    // Guardar posición
    $x = $pdf->GetX();
    $y = $pdf->GetY();

    // Celdas de texto
    $pdf->MultiCell(10, $rowHeight, $row['id'], 1, 'C', false, 0);
    $pdf->MultiCell(30, $rowHeight, $row['ninventario'], 1, 'L', false, 0);
    $pdf->MultiCell(30, $rowHeight, $row['marca'], 1, 'L', false, 0);
    $pdf->MultiCell(30, $rowHeight, $row['narticulo'], 1, 'L', false, 0);
    $pdf->MultiCell(30, $rowHeight, $row['nprovedor'], 1, 'L', false, 0);

    if (!empty($row['imagenmarca'])) {
        $pdf->MultiCell(33, $rowHeight, '', 1, 'C', false, 0);
        $pdf->Image('@' . $row['imagenmarca'], $pdf->GetX() - 30, $y + 2, 25, 20, 'JPG', '', '', true);
    } else {
        $pdf->MultiCell(30, $rowHeight, 'Sin imagen', 1, 'C', false, 0);
    }

    if (!empty($row['imagenarticulo'])) {
        $pdf->MultiCell(33, $rowHeight, '', 1, 'C', false, 0);
        $pdf->Image('@' . $row['imagenarticulo'], $pdf->GetX() - 30, $y + 2, 25, 20, 'JPG', '', '', true);
    } else {
        $pdf->MultiCell(30, $rowHeight, 'Sin imagen', 1, 'C', false, 0);
    }

    $pdf->Ln();
}

$pdf->Output('registroalmacen.pdf', 'I');
$conn->close();
?>