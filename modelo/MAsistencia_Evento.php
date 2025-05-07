<?php
require_once __DIR__ . '/../config/conexion.php';

class MAsistencia_Evento
{
    private $pdo;
    public function __construct()
    {
        $this->pdo = Conexion::conectar();
    }

    // Agregar asistente a evento
    public function agregarAsistente($evento_id, $miembro_id, $cargo_id)
    {
        $sql = "INSERT INTO asistencia_evento (evento_id, miembro_id, cargo_id) VALUES (:evento_id, :miembro_id, :cargo_id)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':evento_id' => $evento_id,
            ':miembro_id' => $miembro_id,
            ':cargo_id' => $cargo_id
        ]);
    }

    // Eliminar asistente de evento
    public function eliminarAsistente($evento_id, $miembro_id)
    {
        $sql = "DELETE FROM asistencia_evento WHERE evento_id = :evento_id AND miembro_id = :miembro_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':evento_id' => $evento_id,
            ':miembro_id' => $miembro_id
        ]);
    }

    // Listar asistentes de un evento
    public function listarAsistentes($evento_id)
    {
        $sql = "SELECT ae.*, m.nombre as miembro_nombre, c.nombre as cargo_nombre FROM asistencia_evento ae JOIN miembro m ON ae.miembro_id = m.id JOIN cargo c ON ae.cargo_id = c.id WHERE ae.evento_id = :evento_id ORDER BY m.nombre ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':evento_id' => $evento_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
