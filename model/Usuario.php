<?php
class Usuario {
    private $usuario_id;

    public function __construct() {
        // Por defecto, es un usuario visitante
        $this->usuario_id = 0;
    }

    public function iniciarSesionComoAdministrador() {
        $this->usuario_id = 1; // Usuario Administrador
    }

    public function cerrarSesion() {
        $this->usuario_id = 0; // Usuario Visitante
    }

    public function getUsuarioId() {
        return $this->usuario_id;
    }
}
?>
