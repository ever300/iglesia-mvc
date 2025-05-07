<?php
require_once __DIR__ . '/../config/conexion.php';

class MMinisterio
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Conexion::conectar();
    }

    // CREATE
    public function crearMinisterio($nombre, $descripcion)
    {
        $sql = "INSERT INTO ministerio (nombre, descripcion) 
                VALUES (:nombre, :descripcion)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':descripcion' => $descripcion
        ]);
    }

    // READ (Todos los ministerios)
    public function listarMinisterio()
    {
        $stmt = $this->pdo->query("SELECT * FROM ministerio ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ (Un ministerio)
    public function obtenerMinisterioPorId($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM ministerio WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE
    public function actualizarMinisterio($id, $nombre, $descripcion)
    {
        $sql = "UPDATE ministerio SET 
                nombre = :nombre, 
                descripcion = :descripcion 
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':nombre' => $nombre,
            ':descripcion' => $descripcion
        ]);
    }

    // DELETE
    public function eliminarMinisterio($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM ministerio WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
