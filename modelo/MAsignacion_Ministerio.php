<?php
require_once __DIR__ . '/../config/conexion.php';

class MAsignacion_Ministerio
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Conexion::conectar();
    }

    // CREATE
    public function crearAsignacion($miembro_id, $ministerio_id, $fecha_inicio, $fecha_final, $estado)
    {
        $sql = "INSERT INTO asignacion_ministerio (miembro_id, ministerio_id, fecha_inicio, fecha_final, estado) VALUES (:miembro_id, :ministerio_id, :fecha_inicio, :fecha_final, :estado)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':miembro_id' => $miembro_id,
            ':ministerio_id' => $ministerio_id,
            ':fecha_inicio' => $fecha_inicio,
            ':fecha_final' => ($fecha_final === '' ? null : $fecha_final),
            ':estado' => $estado
        ]);
    }

    // READ (Todas las asignaciones)
    public function listarAsignaciones()
    {
        $sql = "SELECT am.*, m.nombre as miembro_nombre, min.nombre as ministerio_nombre FROM asignacion_ministerio am JOIN miembro m ON am.miembro_id = m.id JOIN ministerio min ON am.ministerio_id = min.id ORDER BY am.miembro_id, am.ministerio_id ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ (Una asignación)
    public function obtenerAsignacion($miembro_id, $ministerio_id)
    {
        $sql = "SELECT * FROM asignacion_ministerio WHERE miembro_id = :miembro_id AND ministerio_id = :ministerio_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':miembro_id' => $miembro_id,
            ':ministerio_id' => $ministerio_id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE
    public function actualizarAsignacion($miembro_id, $ministerio_id, $fecha_inicio, $fecha_final, $estado)
    {
        $sql = "UPDATE asignacion_ministerio SET fecha_inicio = :fecha_inicio, fecha_final = :fecha_final, estado = :estado WHERE miembro_id = :miembro_id AND ministerio_id = :ministerio_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':miembro_id' => $miembro_id,
            ':ministerio_id' => $ministerio_id,
            ':fecha_inicio' => $fecha_inicio,
            ':fecha_final' => ($fecha_final === '' ? null : $fecha_final),
            ':estado' => $estado
        ]);
    }

    // DELETE
    public function eliminarAsignacion($miembro_id, $ministerio_id)
    {
        $sql = "DELETE FROM asignacion_ministerio WHERE miembro_id = :miembro_id AND ministerio_id = :ministerio_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':miembro_id' => $miembro_id,
            ':ministerio_id' => $ministerio_id
        ]);
    }

}
