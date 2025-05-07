<?php
class Conexion {
    private static $conexion = null;

    public static function conectar() {
        if (self::$conexion === null) {
            $host = 'localhost';              // o '127.0.0.1'
            $dbname = 'db_iglesia';           // tu base de datos
            $usuario = 'postgres';            // tu usuario de PostgreSQL
            $contraseña = '1323';    // cambia por tu contraseña real

            try {
                self::$conexion = new PDO("pgsql:host=$host;dbname=$dbname", $usuario, $contraseña);
                self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }

        return self::$conexion;
    }
}
?>
