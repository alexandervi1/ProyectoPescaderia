<?php
require_once '../model/mJuguetes.php';

// Verificar si la categoría Juguetes es id=1 en tu BD
$categoria = 1; 
$juguetes = obtenerJuguetesPorCategoria($categoria);

// Depuración adicional
if (empty($juguetes)) {
    error_log("La categoría $categoria no tiene productos o no existe");
}

include '../view/Juguetes2.php';
?>