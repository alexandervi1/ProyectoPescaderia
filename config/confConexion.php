<?php
    // Archivo para configuración de la conexión a la base de datos
    $conn=mysqli_connect(hostname: 'localhost', username:'root', password:'', database:'pescaderia');
    if (!$conn) {
        die("Error de conexión con la base de datos: " . mysqli_connect_error());
    }

?>