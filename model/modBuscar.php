<?php
    require_once("../config/confConexion.php");

    $baseDatos = new Database();
    $id = isset($_POST['idBus']) ? (int)$_POST['idBus'] : 0;

    ob_start(); // Inicia el almacenamiento en búfer de salida

    // Verifica que el ID es válido
    if ($id > 0) {
        $datos = $baseDatos->buscarPorID($id);
        if ($datos) {
            $contenidoTabla = "<tr>
                    <td>{$datos['id']}</td>
                    <td>{$datos['nombre']}</td>
                    <td>{$datos['apellido']}</td>
                    <td>{$datos['clave']}</td>
                  </tr>";
        } else {
            $contenidoTabla = "<tr><td colspan='4'>No se encontraron resultados</td></tr>";
        }
    } else {
        $contenidoTabla = "<tr><td colspan='4'>ID no válido</td></tr>";
    }

    // Guarda el contenido de la tabla en una variable
    $contenidoTabla .= ob_get_clean();

    // Incluye el archivo de diseño de la tabla
    include("../view/tabla.html");
?>
