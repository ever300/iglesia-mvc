<?php
require_once __DIR__ . '/../config/conexion.php';

class MMiembro
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Conexion::conectar();
    }

    public function crearMiembro($nombre, $apellido, $fecha_nacimiento, $telefono, $cargo_id)
    {
        $sql = "INSERT INTO miembro (nombre, apellido, fecha_nacimiento, telefono, cargo_id) 
                VALUES (:nombre, :apellido, :fecha_nacimiento, :telefono, :cargo_id)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':apellido' => $apellido,
            ':fecha_nacimiento' => $fecha_nacimiento,
            ':telefono' => $telefono,
            ':cargo_id' => $cargo_id
        ]);
    }

    public function listarMiembro()
    {
        $sql = "SELECT m.*, c.nombre as cargo_nombre, 
                       CONCAT(m.nombre, ' ', m.apellido) AS nombre_completo
                FROM miembro m
                LEFT JOIN cargo c ON m.cargo_id = c.id
                ORDER BY m.id ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function obtenerMiembroPorId($id)
    {
        $sql = "SELECT m.*, c.nombre as cargo_nombre,
                       CONCAT(m.nombre, ' ', m.apellido) AS nombre_completo
                FROM miembro m
                LEFT JOIN cargo c ON m.cargo_id = c.id
                WHERE m.id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarMiembro($id, $nombre, $apellido, $fecha_nacimiento, $telefono, $cargo_id)
    {
        $sql = "UPDATE miembro SET 
                nombre = :nombre, 
                apellido = :apellido, 
                fecha_nacimiento = :fecha_nacimiento, 
                telefono = :telefono,
                cargo_id = :cargo_id 
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':nombre' => $nombre,
            ':apellido' => $apellido,
            ':fecha_nacimiento' => $fecha_nacimiento,
            ':telefono' => $telefono,
            ':cargo_id' => $cargo_id
        ]);
    }

    public function eliminarMiembro($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM miembro WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
