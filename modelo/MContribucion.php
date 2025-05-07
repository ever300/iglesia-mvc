<?php
require_once __DIR__ . '/../config/conexion.php';

class MContribucion
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Conexion::conectar();
    }

    // CREATE
    public function crearContribucion($evento_id, $miembro_id, $tipo, $monto, $fecha_registro = null)
    {
        $sql = "INSERT INTO contribucion (evento_id, miembro_id, tipo, monto, fecha_registro) VALUES (:evento_id, :miembro_id, :tipo, :monto, COALESCE(:fecha_registro, CURRENT_DATE))";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':evento_id' => $evento_id !== '' ? $evento_id : null,
            ':miembro_id' => $miembro_id,
            ':tipo' => $tipo,
            ':monto' => $monto,
            ':fecha_registro' => $fecha_registro
        ]);
    }

    // READ (Todos)
    public function listarContribucion()
    {
        $sql = "SELECT c.*, m.nombre as miembro_nombre, e.nombre as evento_nombre FROM contribucion c LEFT JOIN miembro m ON c.miembro_id = m.id LEFT JOIN evento e ON c.evento_id = e.id ORDER BY c.id ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ (Uno)
    public function obtenerContribucionPorId($id)
    {
        $sql = "SELECT * FROM contribucion WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE
    public function actualizarContribucion($id, $evento_id, $miembro_id, $tipo, $monto, $fecha_registro = null)
    {
        $sql = "UPDATE contribucion SET evento_id = :evento_id, miembro_id = :miembro_id, tipo = :tipo, monto = :monto, fecha_registro = COALESCE(:fecha_registro, fecha_registro) WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':evento_id' => $evento_id !== '' ? $evento_id : null,
            ':miembro_id' => $miembro_id,
            ':tipo' => $tipo,
            ':monto' => $monto,
            ':fecha_registro' => $fecha_registro
        ]);
    }

    // DELETE
    public function eliminarContribucion($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM contribucion WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
