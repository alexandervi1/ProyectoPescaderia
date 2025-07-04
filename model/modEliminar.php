<?php
    include("../config/confConexion.php");
    $baseDatos = new Database();
    $baseDatos->delDatos($_REQUEST['id']);
    header("Location: ../view/viewMostrarD.php");
?>