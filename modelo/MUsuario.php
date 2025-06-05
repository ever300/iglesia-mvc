<?php
require_once __DIR__ . '/../config/conexion.php';

class MUsuario {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::conectar();
    }

    public function obtenerUsuarioPorUsername($username) {
        $stmt = $this->pdo->prepare('SELECT * FROM usuario WHERE username = :username');
        $stmt->execute([':username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crearUsuario($username, $passwordHash, $rol) {
        $sql = 'INSERT INTO usuario (username, password, rol) VALUES (:username, :password, :rol)';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':username' => $username,
            ':password' => $passwordHash,
            ':rol' => $rol
        ]);
    }
}
?>
