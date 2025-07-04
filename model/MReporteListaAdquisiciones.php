<?php
// Incluir archivos necesarios

include("../config/confConexion.php"); // Conexión a la base de datos
include("../view/plantilla2.php");  // Clase PDF

// Extraer datos de la base de datos
$sql = "SELECT p.producto_id, p.nombre, p.descripcion, p.precio, p.stock, p.descuento, p.imagen_url, c.nombre AS categoria
FROM Producto p
JOIN Categoria c ON p.categoria_id = c.categoria_id
WHERE p.stock < 6";

$result = mysqli_query($conn, $sql);

// Crear nuevo PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// Establecer fuente y color de fondo para la cabecera
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(200, 220, 255);

// Definir ancho de columnas
$colWidths = [10, 40, 50, 30, 20, 20, 20]; // Ajuste de columnas

// Calcular el ancho total de la tabla y centrarla
$totalWidth = array_sum($colWidths);
$startX = ($pdf->GetPageWidth() - $totalWidth) / 2;
$pdf->SetY(20);
$pdf->SetX($startX);

// Imprimir cabecera de la tabla
$headers = ["ID", "Nombre", "Descripción", "Categoría", "Descuento", "Precio", "Stock"];
foreach ($headers as $i => $header) {
    $pdf->Cell($colWidths[$i], 10, utf8_decode($header), 1, 0, 'C', true);
}
$pdf->Ln();

// Fuente para el contenido
$pdf->SetFont('Arial', '', 10);

// Imprimir filas de datos
while ($row = $result->fetch_assoc()) {
    $pdf->SetX($startX);
    $pdf->Cell($colWidths[0], 10, $row['producto_id'], 1, 0, 'C');
    $pdf->Cell($colWidths[1], 10, utf8_decode($row['nombre']), 1, 0, 'C');

    // Descripción con salto de línea
    $descripcion = utf8_decode($row['descripcion']);
    $yBefore = $pdf->GetY();
    $pdf->MultiCell($colWidths[2], 10, $descripcion, 1, 'L'); 
    $yAfter = $pdf->GetY();
    $cellHeight = $yAfter - $yBefore;
    
    // Ajustar alineación para las demás celdas
    $pdf->SetXY($startX + array_sum(array_slice($colWidths, 0, 3)), $yBefore);
    $pdf->Cell($colWidths[3], $cellHeight, utf8_decode($row['categoria']), 1, 0, 'C'); // Corregido a 'categoria'
    $pdf->Cell($colWidths[4], $cellHeight, $row['descuento'] . "%", 1, 0, 'C');
    $pdf->Cell($colWidths[5], $cellHeight, "$" . number_format($row['precio'], 2), 1, 0, 'C');
    $pdf->Cell($colWidths[6], $cellHeight, $row['stock'], 1, 1, 'C');
}

// Salida del PDF
$pdf->Output();
?>