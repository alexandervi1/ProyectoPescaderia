<?php
    // Incluyendo la plantilla y la conexión a la base de datos
    require_once("../view/plantilla.php");
    require_once("../config/confConexion.php");

    // Declarar objeto de la clase Database
    $db = new Database();
    // Creo el objeto de la clase PDF
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();

    // TABLA
    // Encabezado de la tabla
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetFillColor(200, 220, 255);
    $pdf->Cell(25, 10, 'ID', 1, 0, 'C', true);
    $pdf->Cell(55, 10, 'Nombre', 1, 0, 'C', true);
    $pdf->Cell(55, 10, 'Apellido', 1, 0, 'C', true);
    $pdf->Cell(55, 10, 'Clave', 1, 1, 'C', true);

    // Mostrar Datos de la Base de datos
    // Obtener los datos de la base de datos
    $resultados = $db->listarDatos();
    // Recorrer los datos
    $pdf->SetFont('Arial', '', 12);
    while ($fila = $resultados->fetch_assoc()) {
        $pdf->Cell(25, 10, $fila['id'], 1);
        $pdf->Cell(55, 10, $fila['nombre'], 1);
        $pdf->Cell(55, 10, utf8_decode($fila['apellido']), 1);
        $pdf->Cell(55, 10, $fila['clave'], 1, 1);
    }

    $pdf->Output('F', 'ListadoEstu.pdf');
?>