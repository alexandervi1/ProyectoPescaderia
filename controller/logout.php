<?php
    //archivo para cerrar sesion
    session_start();
    session_unset();
    session_destroy();
    header("Location: ../index.html");
    exit;
?>