<?php
require_once 'config/conexion.php';

try {
    $conexion = Conexion::conectar();
    echo "✅ Conexión exitosa a la base de datos PostgreSQL.";
} catch (Exception $e) {
    echo "❌ Error de conexión: " . $e->getMessage();
}
