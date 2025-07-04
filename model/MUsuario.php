<?php
require_once __DIR__ . '/../config/confConexion.php';

class UsuarioModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function obtenerNombreAdministrador() {
        $sql = "SELECT nombre_completo FROM usuario WHERE usuario_id = 1";
        $result = mysqli_query($this->conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['nombre_completo'];
        }

        return "Administrador Desconocido";
    }
}
?>