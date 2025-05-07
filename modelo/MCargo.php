<?php
require_once __DIR__ . '/../config/conexion.php';

class MCargo
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Conexion::conectar();
    }

    // CREATE
    public function crearCargo($nombre, $descripcion)
    {
        $sql = "INSERT INTO cargo (nombre, descripcion) VALUES (:nombre, :descripcion)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':descripcion' => $descripcion
        ]);
    }

    // READ (Todos los cargos)
    public function listarCargo()
    {
        $stmt = $this->pdo->query("SELECT * FROM cargo ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ (Un cargo)
    public function obtenerCargoPorId($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM cargo WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE
    public function actualizarCargo($id, $nombre, $descripcion)
    {
        $sql = "UPDATE cargo SET nombre = :nombre, descripcion = :descripcion WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':nombre' => $nombre,
            ':descripcion' => $descripcion
        ]);
    }

    // DELETE
    public function eliminarCargo($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM cargo WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
