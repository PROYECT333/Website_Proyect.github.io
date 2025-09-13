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

// Consulta de los registros
$sql = "SELECT id, ninventario, marca, narticulo, area, imagenmarca, imagenarticulo FROM registrobienes";
$result = $conn->query($sql);
if (!$result) {
    die("Error en la consulta SQL: " . $conn->error);
}

// Crear new archivo de PDF
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 8);



// Título
$pdf->Cell(0, 10, 'Registro de Inventario de Bienes Inmuebles', 0, 1, 'C');

// encabezados
$pdf->SetFillColor(200, 220, 255);
$pdf->SetTextColor(0);
$pdf->SetDrawColor(100, 100, 100);

$pdf->Cell(10, 10, 'ID', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Inventario', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Marca', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Artículo', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Área', 1, 0, 'C', true);
$pdf->Cell(33, 10, 'Imagen Marca', 1, 0, 'C', true);
$pdf->Cell(33, 10, 'Imagen Artículo', 1, 1, 'C', true);

// hacer que se recorran los registros
while ($row = $result->fetch_assoc()) {
    // altura de la fila
    $rowHeight = 23;

    // Guardar posición ahasta ahora
    $x = $pdf->GetX();
    $y = $pdf->GetY();

    // Celdas de texto
    $pdf->MultiCell(10, $rowHeight, $row['id'], 1, 'C', false, 0);
    $pdf->MultiCell(30, $rowHeight, $row['ninventario'], 1, 'L', false, 0);
    $pdf->MultiCell(30, $rowHeight, $row['marca'], 1, 'L', false, 0);
    $pdf->MultiCell(30, $rowHeight, $row['narticulo'], 1, 'L', false, 0);
    $pdf->MultiCell(30, $rowHeight, $row['area'], 1, 'L', false, 0);

    // Imagen de la Marca
    if (!empty($row['imagenmarca'])) {
        $pdf->MultiCell(33, $rowHeight, '', 1, 'C', false, 0);
        $pdf->Image('@' . $row['imagenmarca'], $pdf->GetX() - 30, $y + 2, 25, 20, 'JPG', '', '', true);
    } else {
        $pdf->MultiCell(30, $rowHeight, 'Sin imagen', 1, 'C', false, 0);
    }

    // Imagen del Artículo
    if (!empty($row['imagenarticulo'])) {
        $pdf->MultiCell(33, $rowHeight, '', 1, 'C', false, 0);
        $pdf->Image('@' . $row['imagenarticulo'], $pdf->GetX() - 30, $y + 2, 25, 20, 'JPG', '', '', true);
    } else {
        $pdf->MultiCell(30, $rowHeight, 'Sin imagen', 1, 'C', false, 0);
    }

    // salto
    $pdf->Ln();
}

// visualizar el PDF
$pdf->Output('registroalmacen.pdf', 'I');
$conn->close();
?>