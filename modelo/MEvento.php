<?php
require_once __DIR__ . '/../config/conexion.php';

class MEvento
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Conexion::conectar();
    }

    // CREATE
    public function crearEvento($categoria_id, $nombre, $fecha_inicio, $fecha_final, $lugar)
    {
        $sql = "INSERT INTO evento (categoria_id, nombre, fecha_inicio, fecha_final, lugar) VALUES (:categoria_id, :nombre, :fecha_inicio, :fecha_final, :lugar)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':categoria_id' => $categoria_id,
            ':nombre' => $nombre,
            ':fecha_inicio' => $fecha_inicio,
            ':fecha_final' => ($fecha_final === '' ? null : $fecha_final),
            ':lugar' => $lugar
        ]);
        return $this->pdo->lastInsertId();
    }

    // READ (Todos)
    public function listarEvento()
    {
        $sql = "SELECT evento.*, categoria_evento.nombre as categoria_nombre FROM evento JOIN categoria_evento ON evento.categoria_id = categoria_evento.id ORDER BY evento.id ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ (Uno)
    public function obtenerEventoPorId($id)
    {
        $sql = "SELECT * FROM evento WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE
    public function actualizarEvento($id, $categoria_id, $nombre, $fecha_inicio, $fecha_final, $lugar)
    {
        $sql = "UPDATE evento SET categoria_id = :categoria_id, nombre = :nombre, fecha_inicio = :fecha_inicio, fecha_final = :fecha_final, lugar = :lugar WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':categoria_id' => $categoria_id,
            ':nombre' => $nombre,
            ':fecha_inicio' => $fecha_inicio,
            ':fecha_final' => ($fecha_final === '' ? null : $fecha_final),
            ':lugar' => $lugar
        ]);
    }

    // DELETE
    public function eliminarEvento($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM evento WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
