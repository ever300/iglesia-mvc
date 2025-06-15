<?php
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../config/ControllerFactory.php';

class Client {
    public function handle() {
        $controller = $_GET['controller'] ?? null;
        if ($controller) {
            $instance = ControllerFactory::create($controller);
            $instance->handleRequest();
            return true;
        }
        return false;
    }
}
?>
