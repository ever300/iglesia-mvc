<?php
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../observador/EventoObserver.php';

class MEvento
{
    private $pdo;
    private $observers = [];

    public function __construct()
    {
        $this->pdo = Conexion::conectar();
    }

    public function attach(EventoObserver $observer)
    {
        $this->observers[] = $observer;
    }

    public function detach(EventoObserver $observer)
    {
        foreach ($this->observers as $index => $obs) {
            if ($obs === $observer) {
                unset($this->observers[$index]);
            }
        }
    }

    private function notify(int $eventoId, array $data)
    {
        foreach ($this->observers as $observer) {
            $observer->update($eventoId, $data);
        }
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
        $id = $this->pdo->lastInsertId();
        $this->notify($id, [
            'accion' => 'crear',
            'datos' => [
                'categoria_id' => $categoria_id,
                'nombre' => $nombre,
                'fecha_inicio' => $fecha_inicio,
                'fecha_final' => ($fecha_final === '' ? null : $fecha_final),
                'lugar' => $lugar
            ]
        ]);
        return $id;
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
        $resultado = $stmt->execute([
            ':id' => $id,
            ':categoria_id' => $categoria_id,
            ':nombre' => $nombre,
            ':fecha_inicio' => $fecha_inicio,
            ':fecha_final' => ($fecha_final === '' ? null : $fecha_final),
            ':lugar' => $lugar
        ]);
        if ($resultado) {
            $this->notify($id, [
                'accion' => 'actualizar',
                'datos' => [
                    'categoria_id' => $categoria_id,
                    'nombre' => $nombre,
                    'fecha_inicio' => $fecha_inicio,
                    'fecha_final' => ($fecha_final === '' ? null : $fecha_final),
                    'lugar' => $lugar
                ]
            ]);
        }
        return $resultado;
    }

    // DELETE
    public function eliminarEvento($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM evento WHERE id = :id");
        $resultado = $stmt->execute([':id' => $id]);
        if ($resultado) {
            $this->notify($id, ['accion' => 'eliminar']);
        }
        return $resultado;
    }
}
