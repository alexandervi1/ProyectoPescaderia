<?php
    include("../config/confConexion.php");
    $baseDatos = new Database();
    $id = $_REQUEST['id'];
    $nombre = $_REQUEST['nombre'];
    $apellido = $_REQUEST['apellido'];
    $clave = $_REQUEST['clave'];
    $baseDatos->editDatos($id, $nombre, $apellido, $clave);
    header("Location: ../view/viewMostrarD.php");
?>