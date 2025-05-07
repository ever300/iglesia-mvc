<?php
require_once __DIR__ . '/../config/conexion.php';

class MCategoria_evento
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Conexion::conectar();
    }

    // CREATE
    public function crearCategoria_evento($nombre, $descripcion)
    {
        $sql = "INSERT INTO categoria_evento (nombre, descripcion) VALUES (:nombre, :descripcion)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':descripcion' => $descripcion
        ]);
    }

    // READ (Todos)
    public function listarCategoria_evento()
    {
        $stmt = $this->pdo->query("SELECT * FROM categoria_evento ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ (Uno)
    public function obtenerCategoria_eventoPorId($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM categoria_evento WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE
    public function actualizarCategoria_evento($id, $nombre, $descripcion)
    {
        $sql = "UPDATE categoria_evento SET nombre = :nombre, descripcion = :descripcion WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':nombre' => $nombre,
            ':descripcion' => $descripcion
        ]);
    }

    // DELETE
    public function eliminarCategoria_evento($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM categoria_evento WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
