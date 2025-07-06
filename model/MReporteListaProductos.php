<?php
// Inicia la sesión si aún no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Incluir la configuración de conexión a la base de datos
require_once '../config/confConexion.php';

// Incluir la librería FPDF
require('../Reportes/fpdf186/fpdf.php');

// =========================================================================
// CLASE PDF EXTENDIDA (con logo, footer mejorado y color de encabezado personalizado)
// =========================================================================
class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image('../public/img/Pescaderia Don Walter logo.png', 10, 8, 30); 

        // Arial bold 15 para el título principal
        $this->SetFont('Arial','B',15);
        
        // Mover Y para el título
        $this->SetY(15); 
        
        // Título principal centrado
        $this->Cell(0,10,utf8_decode('Reporte de Productos'),0,0,'C');
        
        // Salto de línea para la siguiente línea (nombre de la empresa)
        $this->Ln(5); 
        
        // Fuente para el subtítulo (nombre de la empresa)
        $this->SetFont('Arial','I',10);
        // Subtítulo centrado
        $this->Cell(0,10,utf8_decode('Pescadería Don Walter'),0,0,'C');

        // Salto de línea después del subtítulo para dejar espacio antes de la tabla
        $this->Ln(15);
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 3 cm del final
        $this->SetY(-30); 

        // Línea separadora
        $this->SetDrawColor(180, 180, 180); 
        $this->Line(10, $this->GetY(), 200, $this->GetY()); 

        // Información de Contacto
        $this->SetFont('Arial','',8); 
        $this->Cell(0,5,utf8_decode('Contacto: 09924700553 - 0982744920'),0,1,'C'); 

        // Dirección
        $this->Cell(0,5,utf8_decode('Dirección: Av. Canónigo Ramos y Av. 11 de Noviembre, Riobamba, Chimborazo, Ecuador'),0,1,'C');

        // Espacio para la información de redes sociales o referencia
        $this->Ln(2); 

        // Información de Redes Sociales (solo texto)
        $this->SetFont('Arial','I',7); 
        $this->Cell(0,4,utf8_decode('Síguenos en redes sociales: Facebook, TikTok, WhatsApp'),0,1,'C');

        // Espacio para el número de página
        $this->SetY(-8); 
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,5,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
    }
}

// =========================================================================
// INICIAR LA GENERACIÓN DEL PDF (Resto del código sin cambios)
// =========================================================================

$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',10);

// Define las anchuras de las columnas
$ancho_id = 15;
$ancho_nombre = 45;
$ancho_categoria = 30;
$ancho_precio = 20;
$ancho_stock = 20;
$ancho_ucompra = 30;
$ancho_uventa = 30;

// =========================================================================
// ENCABEZADOS DE LA TABLA (¡COLOR ACTUALIZADO AQUÍ!)
// =========================================================================
$pdf->SetFillColor(26, 81, 157); // Color #1A519D en RGB
$pdf->SetTextColor(255,255,255); // Color de texto blanco
$pdf->SetFont('Arial','B',8);

$pdf->Cell($ancho_id, 7, 'ID', 1, 0, 'C', true);
$pdf->Cell($ancho_nombre, 7, 'Nombre', 1, 0, 'C', true);
$pdf->Cell($ancho_categoria, 7, utf8_decode('Categoría'), 1, 0, 'C', true);
$pdf->Cell($ancho_precio, 7, 'Precio', 1, 0, 'C', true);
$pdf->Cell($ancho_stock, 7, 'Stock', 1, 0, 'C', true);
$pdf->Cell($ancho_ucompra, 7, 'U. Compra', 1, 0, 'C', true);
$pdf->Cell($ancho_uventa, 7, 'U. Venta', 1, 1, 'C', true);

// =========================================================================
// DATOS DE LA TABLA (sin cambios)
// =========================================================================
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',8);

$sql = "SELECT
            p.producto_id,
            p.nombre,
            p.descripcion,
            p.precio,
            p.stock,
            p.imagen_url,
            c.nombre AS categoria_nombre,
            uc.nombre AS unidad_compra_nombre,
            uv.nombre AS unidad_venta_nombre
        FROM
            producto AS p
        LEFT JOIN
            unidad_medida AS uc ON p.unidad_compra_id = uc.unidad_id
        LEFT JOIN
            unidad_medida AS uv ON p.unidad_venta_id = uv.unidad_id
        LEFT JOIN
            categoria AS c ON p.categoria_id = c.categoria_id
        ORDER BY p.producto_id ASC";

$resultado = mysqli_query($conn, $sql);

$fill = false;

if ($resultado && mysqli_num_rows($resultado) > 0) {
    while ($mostrar = mysqli_fetch_array($resultado)) {
        $pdf->SetFillColor($fill ? 240 : 255, $fill ? 240 : 255, $fill ? 240 : 255);
        $fill = !$fill;

        $pdf->Cell($ancho_id, 6, $mostrar['producto_id'], 1, 0, 'C', true);
        $pdf->Cell($ancho_nombre, 6, utf8_decode($mostrar['nombre']), 1, 0, 'L', true);
        $pdf->Cell($ancho_categoria, 6, utf8_decode($mostrar['categoria_nombre']), 1, 0, 'L', true);
        $pdf->Cell($ancho_precio, 6, '$' . number_format($mostrar['precio'], 2), 1, 0, 'R', true);
        $pdf->Cell($ancho_stock, 6, $mostrar['stock'], 1, 0, 'C', true);
        $pdf->Cell($ancho_ucompra, 6, utf8_decode($mostrar['unidad_compra_nombre']), 1, 0, 'L', true);
        $pdf->Cell($ancho_uventa, 6, utf8_decode($mostrar['unidad_venta_nombre']), 1, 1, 'L', true);
    }
} else {
    $pdf->SetFillColor(255, 255, 255);
    $pdf->Cell(array_sum([$ancho_id, $ancho_nombre, $ancho_categoria, $ancho_precio, $ancho_stock, $ancho_ucompra, $ancho_uventa]), 10, utf8_decode('No se encontraron productos para generar el reporte.'), 1, 1, 'C', true);
}

mysqli_close($conn);
$pdf->Output('I', 'Reporte_Productos_Pescaderia_Don_Walter_' . date('Ymd_His') . '.pdf');
?>