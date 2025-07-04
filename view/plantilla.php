<?php
require_once('../Reportes/fpdf186/fpdf.php');

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image('../img/Logo1.png', 10, 6, 35);

        // Título junto al logo
        $this->SetFont('Arial', 'B', 14);
        $this->SetXY(40, 10); // Mover el título a la derecha del logo
        $this->Cell(120, 10, 'Lista de Productos', 0, 1, 'C');

        // Línea de separación
        $this->Ln(5);
        $this->Cell(190, 0, '', 'B', 1, 'C');
        $this->Ln(10);
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Página ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}
?>